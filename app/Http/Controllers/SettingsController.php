<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\FormFieldInput;
use App\Http\Functions;
use App\Models\File;
use App\Models\Institution;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $total_user = Functions::getTotalUser();

        $form_field_keys = array(
            FormFieldInput::FIELD_KEY_LOGIN,
            FormFieldInput::FIELD_KEY_EMAIL,
            FormFieldInput::FIELD_KEY_WHO_CAN_SEE_EMAIL,
            FormFieldInput::FIELD_KEY_PHONE,
            FormFieldInput::FIELD_KEY_WHO_CAN_SEE_PHONE,
            FormFieldInput::FIELD_KEY_FIRST_NAME,
            FormFieldInput::FIELD_KEY_SECOND_NAME,
            FormFieldInput::FIELD_KEY_THIRD_NAME,
            FormFieldInput::FIELD_KEY_INSTITUTION_ID,
            FormFieldInput::FIELD_KEY_NEW_PASSWORD,
            FormFieldInput::FIELD_KEY_NEW_PASSWORD_CONFIRMED,
            FormFieldInput::FIELD_KEY_TOTAL_PASSWORD
        );
        $form_field_defaults = array(
            FormFieldInput::FIELD_KEY_LOGIN => $total_user->login,
            FormFieldInput::FIELD_KEY_EMAIL => $total_user->email,
            FormFieldInput::FIELD_KEY_WHO_CAN_SEE_EMAIL => $total_user->show_email,
            FormFieldInput::FIELD_KEY_PHONE => $total_user->phone,
            FormFieldInput::FIELD_KEY_WHO_CAN_SEE_PHONE => $total_user->show_phone,
            FormFieldInput::FIELD_KEY_FIRST_NAME => $total_user->first_name,
            FormFieldInput::FIELD_KEY_SECOND_NAME => $total_user->second_name,
            FormFieldInput::FIELD_KEY_THIRD_NAME => $total_user->third_name,
            FormFieldInput::FIELD_KEY_INSTITUTION_ID => $total_user->institution->id ?? null,
        );
        $fields_options_values = array(
            FormFieldInput::FIELD_KEY_INSTITUTION_ID => FormFieldInput::generateOneFieldArray(Institution::all('id as value')->toArray()),
            FormFieldInput::FIELD_KEY_WHO_CAN_SEE_EMAIL => Functions::SETTINS_VALUES,
            FormFieldInput::FIELD_KEY_WHO_CAN_SEE_PHONE => Functions::SETTINS_VALUES,
        );
        $fields_options_values_guarded = null;
        $fields_options_names = array(
            FormFieldInput::FIELD_KEY_INSTITUTION_ID => FormFieldInput::generateOneFieldArray(Institution::all('full_name as value')->toArray()),
            FormFieldInput::FIELD_KEY_WHO_CAN_SEE_EMAIL => Functions::SETTINS_VALUES_NAMES,
            FormFieldInput::FIELD_KEY_WHO_CAN_SEE_PHONE => Functions::SETTINS_VALUES_NAMES,
        );
        $html_fields = FormFieldInput::generateHtmlFields($request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded, $fields_options_names);

        $avatar_file = null;
        $notification = null;
        $errors = null;

        if ($request->isMethod('post'))
        {
            $errors = array();

            FormFieldInput::checkInputs($errors, $request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded);

            FormFieldInput::checkInputNewPasswordConfirmed($request, $errors);

            if (count($errors) == 0)
            {
                // Проверка текущего пароля
                $password_sha512 = hash('sha512', $request->input(FormFieldInput::FIELD_KEY_TOTAL_PASSWORD));
                if ($password_sha512 != $total_user->password_sha512)
                {
                    $errors[] = 'Неверный текущий пароль!';
                }
            }

            if (count($errors) == 0)
            {
                $new_login = $request->input(FormFieldInput::FIELD_KEY_LOGIN);
                if($new_login != $total_user->login) // Если пользователь изменил логин
                {
                    FormFieldInput::checkInputIsLoginAlreadyExists($request, $errors);
                }

                if (count($errors) == 0)
                {
                    $new_password = $request->input(FormFieldInput::FIELD_KEY_NEW_PASSWORD);
                    if($new_password != null)
                    {
                        $password_sha512 = hash('sha512', $new_password);
                    }

                    $file = null;
                    if($request->hasFile('avatar'))
                    {
                        $file = $request->file('avatar');

                        $allowed_mime_types = array(
                            'image/png',
                            'image/jpeg',
                            'image/gif',
                        );

                        if(in_array($file->getMimeType(), $allowed_mime_types) == false)
                        {
                            $errors[] = 'Файл имеет недопустимый формат!';
                        }
                        else
                        {
                            if($file->getSize() > 1024*1024*3)
                            {
                                $errors[] = 'Максимальный размер файла - 3 мб!';
                            }
                        }
                    }
                    if(count($errors) == 0)
                    {
                        try
                        {
                            if($file != null) // если аватарка была изменена
                            {
                                if($total_user->avatar_file != null) // если у пользователя уже установлен аватар - его удалим из системы
                                {
                                    $db_file = $total_user->avatar_file;
                                    $db_file->fileDelete(); // удаляем файл с сервера
                                    $total_user->avatar_file()->dissociate(); // открепляем аватар от пользователя
                                    $total_user->save();
                                    $db_file->delete(); // удаляем информацию о файле из БД
                                }

                                $db_file = new File;
                                $db_file->name = $file->getClientOriginalName();
                                $db_file->prefix = 'avatars';
                                $db_file->filename = time().'_'.$total_user->id.'_'.random_int(1000, 9999).'_'.$db_file->name;
                                $db_file->user_from()->associate($total_user);
                                $total_user->avatar_file()->associate($db_file);
                                $db_file->fileUpload($file); // сохранение файла на сервер
                                $db_file->save();
                                $total_user->avatar_file()->associate($db_file);
                            }

                            // Изменение и сохранение пользователя
                            $total_user->login = $new_login;
                            $total_user->email = $request->input(FormFieldInput::FIELD_KEY_EMAIL);
                            $total_user->show_email = $request->input(FormFieldInput::FIELD_KEY_WHO_CAN_SEE_EMAIL);
                            $total_user->phone = $request->input(FormFieldInput::FIELD_KEY_PHONE);
                            $total_user->show_phone = $request->input(FormFieldInput::FIELD_KEY_WHO_CAN_SEE_PHONE);
                            $total_user->first_name = $request->input(FormFieldInput::FIELD_KEY_FIRST_NAME);
                            $total_user->second_name = $request->input(FormFieldInput::FIELD_KEY_SECOND_NAME);
                            $total_user->third_name = $request->input(FormFieldInput::FIELD_KEY_THIRD_NAME);
                            $total_user->password_sha512 = $password_sha512;
                            $total_user->institution()->associate(Institution::find($request->input(FormFieldInput::FIELD_KEY_INSTITUTION_ID)));
                            $total_user->last_activity_at = now();
                            $total_user->save();
                            Functions::saveSession($total_user);
                            $notification = 'Настройки успешно изменены!';
                        }
                        catch (\Exception $exception)
                        {
                            $errors[] = $exception->getMessage();
                        }
                    }
                }
            }
        }

        return response()->view('settings.index', [
            'html_fields' => $html_fields,
            'total_user' => $total_user,
            'notification' => $notification,
            'errors' => $errors
        ])->header('Content-Type', 'text/html');
    }
}
