<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\FormFieldInput;
use App\Http\Functions;
use App\Models\Chat;
use App\Models\ChatType;
use App\Models\Practice;
use App\Models\User;
use App\Models\UsersToPracticesStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PracticesController extends Controller
{
    public function index()
    {
        $total_user = Functions::getTotalUser();
        $practices = $total_user->practices()->orderBy('id')->paginate(10);
        return response()->view('practices.index', [
            'total_user' => $total_user,
            'practices' => $practices,
        ])->header('Content-Type', 'text/html');
    }

    public function create(Request $request)
    {
        $total_user = Functions::getTotalUser();

        $form_field_keys = array(
            FormFieldInput::FIELD_KEY_PRACTICE_NAME,
            FormFieldInput::FIELD_KEY_PRACTICE_DESCRIPTION,
            FormFieldInput::FIELD_KEY_PRACTICE_START_AT,
            FormFieldInput::FIELD_KEY_PRACTICE_END_AT,
            FormFieldInput::FIELD_KEY_PRACTICE_IS_CLOSED,
            FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_KEY,
            FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_CLOSED_AT,
        );
        $form_field_defaults = array(
            FormFieldInput::FIELD_KEY_PRACTICE_NAME => 'Производственная практика '.now()->toDateTimeString(),
            FormFieldInput::FIELD_KEY_PRACTICE_START_AT => now()->toDateTimeString(),
            FormFieldInput::FIELD_KEY_PRACTICE_END_AT => now()->addDays(28)->toDateTimeString(),
            FormFieldInput::FIELD_KEY_PRACTICE_IS_CLOSED => 0,
            FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_KEY => Practice::generateRandomRegistrationKey(),
            FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_CLOSED_AT => now()->addDays(7)->toDateTimeString(),
        );
        $fields_options_values = array(
            FormFieldInput::FIELD_KEY_PRACTICE_IS_CLOSED => array(0, 1),
        );
        $fields_options_values_guarded = null;
        $fields_options_names = array(
            FormFieldInput::FIELD_KEY_PRACTICE_IS_CLOSED => array('Нет', 'Да'),
        );
        $html_fields = FormFieldInput::generateHtmlFields($request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded, $fields_options_names);

        $notification = null;
        $errors = null;

        if ($request->isMethod('post'))
        {
            $errors = array();

            FormFieldInput::checkInputs($errors, $request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded);
            FormFieldInput::checkInputIsPracticeNameAlreadyExists($request, $errors);
            FormFieldInput::checkInputIsPracticeRegistrationKeyAlreadyExists($request, $errors);

            if(count($errors) == 0)
            {
                $start_at = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_START_AT);
                $end_at = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_END_AT);
                $registration_closed_at = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_CLOSED_AT);
                try{
                    $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $start_at);
                    $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $end_at);
                    $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $registration_closed_at);
                }
                catch (\Exception $exception)
                {
                    $errors[] = 'Неверный формат даты и времени! Введите дату и время в формате по примеру: '.now()->addDay(1)->toDateTimeString().'.';
                }

                if(count($errors) == 0)
                {
                    try
                    {
                        $practice = new Practice;
                        $practice->name = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_NAME);
                        $practice->description = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_DESCRIPTION);
                        $practice->user_from()->associate($total_user);
                        $practice->start_at = $start_at;
                        $practice->end_at = $end_at;
                        $practice->is_closed = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_IS_CLOSED);
                        $practice->registration_key = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_KEY);
                        $practice->registration_closed_at = $registration_closed_at;
                        $practice->save();
                        $practice->users()->attach($total_user, ['users_to_practices_status_id' => UsersToPracticesStatus::USERS_TO_PRACTICES_STATUS_ID_REGISTERED]);

                        $chat = new Chat;
                        $chat->chat_type()->associate(ChatType::find(ChatType::CHAT_TYPE_ID_PRACTIC));
                        $chat->practice()->associate($practice);
                        $chat->save();
                        $chat->users()->attach($total_user);

                        return redirect()->route('practices_view', $practice->id)->header('Content-Type', 'text/html');
                    }
                    catch (\Exception $exception)
                    {
                        $errors[] = $exception->getMessage();
                    }
                }
            }
        }

        return response()
            ->view('practices.create', [
                'html_fields' => $html_fields,
                'errors' => $errors,
                'total_user' => $total_user
            ])
            ->header('Content-Type', 'text/html');
    }

    public function join(Request $request, $_registration_key = null)
    {
        $total_user = Functions::getTotalUser();

        $form_field_keys = array(
            FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_KEY,
        );
        $form_field_defaults = array(
            FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_KEY => $_registration_key,
        );
        $fields_options_values = null;
        $fields_options_values_guarded = null;
        $fields_options_names = null;
        $html_fields = FormFieldInput::generateHtmlFields($request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded, $fields_options_names);

        $notification = null;
        $errors = null;

        if ($request->isMethod('post') || ($request->isMethod('get') && ($_registration_key != null)))
        {
            $errors = array();

            if($request->isMethod('post'))
            {
                FormFieldInput::checkInputs($errors, $request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded);
            }

            if(count($errors) == 0)
            {
                $registration_key = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_KEY);

                if($request->isMethod('get'))
                {
                    if ($_registration_key != null)
                    {
                        $registration_key = $_registration_key;
                    }
                }

                /**
                 * @var Practice $practice
                */
                $practice = Practice::where('registration_key', '=', $registration_key)->first();

                if($practice == null)
                {
                    $errors[] = 'Практика не найдена!';
                }
                else
                {
                    if($practice->users()->find($total_user->id) != null)
                    {
                        $errors[] = 'Вы уже состоите в данной практике!';
                    }
                    else
                    {
                        $registration_closed_at = new Carbon($practice->registration_closed_at);
                        if(now()->greaterThan($registration_closed_at))
                        {
                            $errors[] = 'Регистрация на практику закончилась!';
                        }
                        else if ($practice->is_closed)
                        {
                            $errors[] = 'Практика закрыта!';
                        }
                    }
                }

                if(count($errors) == 0)
                {
                    try
                    {
                        $practice->users()->attach($total_user, ['users_to_practices_status_id' => UsersToPracticesStatus::USERS_TO_PRACTICES_STATUS_ID_REGISTERED]);
                        $practice->getPracticeMainChatOrFail()->users()->attach($total_user);

                        return redirect()->route('practices_view', $practice->id)->header('Content-Type', 'text/html');
                    }
                    catch (\Exception $exception)
                    {
                        $errors[] = $exception->getMessage();
                    }
                }
            }
        }

        return response()
            ->view('practices.join', [
                'html_fields' => $html_fields,
                'errors' => $errors,
                'total_user' => $total_user
            ])
            ->header('Content-Type', 'text/html');
    }

    public function view($practice_id)
    {
        $total_user = Functions::getTotalUser();
        $practice = Practice::findOrFail($practice_id);
        if($total_user->isUserInPractice($practice) == false) // если пользователь не состоит в пракике
        {
            return redirect()->route('practices')->header('Content-Type', 'text/html');
        }
        $chat = $practice->getPracticeMainChatOrFail();
        $users = $practice->users()->paginate(10);

        $user_to_chat = $total_user->chats()->find($chat->id)->user_to_chat;
        $user_to_chat->messages_not_read = 0;
        $user_to_chat->save();

        return response()->view('practices.view', [
            'total_user' => $total_user,
            'practice' => $practice,
            'chat' => $chat,
            'users' => $users,
        ])->header('Content-Type', 'text/html');
    }

    public function edit(Request $request, $practice_id)
    {
        $total_user = Functions::getTotalUser();
        $practice = Practice::findOrFail($practice_id);

        $form_field_keys = array(
            FormFieldInput::FIELD_KEY_PRACTICE_NAME,
            FormFieldInput::FIELD_KEY_PRACTICE_DESCRIPTION,
            FormFieldInput::FIELD_KEY_PRACTICE_START_AT,
            FormFieldInput::FIELD_KEY_PRACTICE_END_AT,
            FormFieldInput::FIELD_KEY_PRACTICE_IS_CLOSED,
            FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_KEY,
            FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_CLOSED_AT,
        );
        $form_field_defaults = array(
            FormFieldInput::FIELD_KEY_PRACTICE_NAME => $practice->name,
            FormFieldInput::FIELD_KEY_PRACTICE_DESCRIPTION => $practice->description,
            FormFieldInput::FIELD_KEY_PRACTICE_START_AT => $practice->start_at,
            FormFieldInput::FIELD_KEY_PRACTICE_END_AT => $practice->end_at,
            FormFieldInput::FIELD_KEY_PRACTICE_IS_CLOSED => $practice->is_closed,
            FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_KEY => $practice->registration_key,
            FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_CLOSED_AT => $practice->registration_closed_at,
        );
        $fields_options_values = array(
            FormFieldInput::FIELD_KEY_PRACTICE_IS_CLOSED => array(0, 1),
        );
        $fields_options_values_guarded = null;
        $fields_options_names = array(
            FormFieldInput::FIELD_KEY_PRACTICE_IS_CLOSED => array('Нет', 'Да'),
        );
        $html_fields = FormFieldInput::generateHtmlFields($request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded, $fields_options_names);

        $notification = null;
        $errors = null;

        if ($request->isMethod('post'))
        {
            $errors = array();

            FormFieldInput::checkInputs($errors, $request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded);

            $new_name = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_NAME);
            if($new_name != $practice->name) // Если пользователь изменил название практики
            {
                FormFieldInput::checkInputIsPracticeNameAlreadyExists($request, $errors);
            }

            $new_registration_key = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_KEY);
            if($new_registration_key != $practice->registration_key) // Если пользователь изменил ключ регистрации
            {
                FormFieldInput::checkInputIsPracticeRegistrationKeyAlreadyExists($request, $errors);
            }

            if(count($errors) == 0)
            {
                $start_at = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_START_AT);
                $end_at = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_END_AT);
                $registration_closed_at = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_REGISTRATION_CLOSED_AT);
                try{
                    $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $start_at);
                    $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $end_at);
                    $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $registration_closed_at);
                }
                catch (\Exception $exception)
                {
                    $errors[] = 'Неверный формат даты и времени! Введите дату и время в формате по примеру: '.now()->addDay(1)->toDateTimeString().'.';
                }

                if(count($errors) == 0)
                {
                    try
                    {
                        $practice->name = $new_name;
                        $practice->description = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_DESCRIPTION);
                        $practice->start_at = $start_at;
                        $practice->end_at = $end_at;
                        $practice->is_closed = $request->input(FormFieldInput::FIELD_KEY_PRACTICE_IS_CLOSED);
                        $practice->registration_key = $new_registration_key;
                        $practice->registration_closed_at = $registration_closed_at;
                        $practice->save();

                        $notification = 'Практика успешно изменена!';
                    }
                    catch (\Exception $exception)
                    {
                        $errors[] = $exception->getMessage();
                    }
                }
            }
        }

        return response()
            ->view('practices.edit', [
                'html_fields' => $html_fields,
                'notification' => $notification,
                'errors' => $errors,
                'total_user' => $total_user,
                'practice' => $practice
            ])
            ->header('Content-Type', 'text/html');
    }

    public function delete(Request $request, $practice_id)
    {
        $total_user = Functions::getTotalUser();
        $practice = Practice::findOrFail($practice_id);
        if($total_user->hasPermissionOnPractice($practice) == false) // если пользователь не имеет прав на управление практикой
        {
            return redirect()->route('practices')->header('Content-Type', 'text/html');
        }
        else
        {
            if($request->isMethod('post'))
            {
                $practice->delete();
                return redirect()->route('practices')->header('Content-Type', 'text/html');
            }
            else
            {
                return response()->view('practices.delete', [
                    'total_user' => $total_user,
                    'practice' => $practice,
                ])->header('Content-Type', 'text/html');
            }
        }
    }

    public function remove_user($practice_id, $user_id)
    {
        $total_user = Functions::getTotalUser();
        $practice = Practice::findOrFail($practice_id);
        $removing_user = User::findOrFail($user_id);

        if($total_user->hasPermissionOnPractice($practice)) // Если пользователь имеет права
        {
            if($total_user->id != $removing_user->id) // нельзя удалить самого себя
            {
                $practice->getPracticeMainChatOrFail()->users()->detach($removing_user); // удаляем указанного пользователя с практики
                $practice->users()->detach($removing_user); // удаляем указанного пользователя с практики
            }
        }

        return redirect()->route('practices_view', $practice_id)->header('Content-Type', 'text/html');
    }
}
