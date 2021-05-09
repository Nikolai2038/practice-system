<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\FormFieldInput;
use App\Http\Functions;
use App\Models\Institution;
use App\Models\InstitutionType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $total_user = Functions::getTotalUser();

        $form_field_keys = array(
            FormFieldInput::FIELD_KEY_LOGIN,
            FormFieldInput::FIELD_KEY_EMAIL,
            FormFieldInput::FIELD_KEY_PHONE,
            FormFieldInput::FIELD_KEY_FIRST_NAME,
            FormFieldInput::FIELD_KEY_SECOND_NAME,
            FormFieldInput::FIELD_KEY_THIRD_NAME,
            FormFieldInput::FIELD_KEY_INSTITUTION_ID,
            FormFieldInput::FIELD_KEY_PASSWORD,
            FormFieldInput::FIELD_KEY_PASSWORD_CONFIRMED
        );
        $form_field_defaults = null;
        $fields_options_values = array(
            FormFieldInput::FIELD_KEY_INSTITUTION_ID => FormFieldInput::generateOneFieldArray(Institution::all('id as value')->toArray()),
        );
        $fields_options_values_guarded = null;
        $fields_options_names = array(
            FormFieldInput::FIELD_KEY_INSTITUTION_ID => FormFieldInput::generateOneFieldArray(Institution::all('full_name as value')->toArray()),
        );
        $html_fields = FormFieldInput::generateHtmlFields($request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded, $fields_options_names);

        if ($request->isMethod('get'))
        {
            return response()->view('registration.index', ['html_fields' => $html_fields, 'total_user' => $total_user])->header('Content-Type', 'text/html');
        }
        else if ($request->isMethod('post'))
        {
            $errors = array();

            FormFieldInput::checkInputs($errors, $request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded);

            FormFieldInput::checkInputPasswordConfirmed($request, $errors);

            if (count($errors) == 0)
            {
                FormFieldInput::checkInputIsLoginAlreadyExists($request, $errors);

                if (count($errors) == 0)
                {
                    $password_sha512 = hash('sha512', $request->input(FormFieldInput::FIELD_KEY_PASSWORD));

                    // Создание и сохранение нового пользователя
                    $user = new User;
                    $user->login = $request->input(FormFieldInput::FIELD_KEY_LOGIN);
                    $user->email = $request->input(FormFieldInput::FIELD_KEY_EMAIL);
                    $user->phone = $request->input(FormFieldInput::FIELD_KEY_PHONE);
                    $user->first_name = $request->input(FormFieldInput::FIELD_KEY_FIRST_NAME);
                    $user->second_name = $request->input(FormFieldInput::FIELD_KEY_SECOND_NAME);
                    $user->third_name = $request->input(FormFieldInput::FIELD_KEY_THIRD_NAME);
                    $user->password_sha512 = $password_sha512;
                    $user->role()->associate(Role::find(Role::ROLE_ID_USER));
                    $user->institution()->associate(Institution::find($request->input(FormFieldInput::FIELD_KEY_INSTITUTION_ID)));
                    $user->last_activity_at = now();
                    $user->save();

                    Functions::saveSession($user);
                    return redirect()->route(Functions::ROUTE_NAME_TO_REDIRECT_FROM_AUTHORIZATION)->header('Content-Type', 'text/html');
                }
            }
            return response()
                ->view('registration.index', [
                    'html_fields' => $html_fields,
                    'errors' => $errors,
                    'total_user' => $total_user
                ])
                ->header('Content-Type', 'text/html');
        }
    }
}
