<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Functions;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('get'))
        {
            return response()->view('registration.index', ['total_user' => null])->header('Content-Type', 'text/html');
        }
        else if ($request->isMethod('post'))
        {
            $errors = array();

            Functions::checkInput($request,'login','Логин',Functions::MIN_LENGTH_LOGIN,Functions::MAX_LENGTH_LOGIN,true,$errors);
            Functions::checkInput($request,'email','Email',Functions::MIN_LENGTH_EMAIL,Functions::MAX_LENGTH_EMAIL,false,$errors);
            Functions::checkInput($request,'first_name','Имя',Functions::MIN_LENGTH_FIRST_NAME,Functions::MAX_LENGTH_FIRST_NAME,true,$errors);
            Functions::checkInput($request,'second_name','Фамилия',Functions::MIN_LENGTH_SECOND_NAME,Functions::MAX_LENGTH_SECOND_NAME,true,$errors);
            Functions::checkInput($request,'third_name','Отчество',Functions::MIN_LENGTH_THIRD_NAME,Functions::MAX_LENGTH_THIRD_NAME,false,$errors);
            Functions::checkInput($request, 'password', 'Пароль', Functions::MIN_LENGTH_PASSWORD, Functions::MAX_LENGTH_PASSWORD, true, $errors);
            Functions::checkInput($request, 'password_confirmed', 'Подтверждение пароля', Functions::MIN_LENGTH_PASSWORD, Functions::MAX_LENGTH_PASSWORD, true, $errors);

            $password = $request->input('password');
            $password_confirmed = $request->input('password_confirmed');
            if($password != $password_confirmed)
            {
                $errors[] = 'Пароли не совпадают!';
            }

            if (count($errors) == 0)
            {
                $user_found = User::where('login', '=', $request->input('login'))->first();

                if ($user_found != null)
                {
                    $errors[] = 'Пользователь с таким логином уже зарегистрирован!';
                }
                else
                {
                    $password_sha512 = hash('sha512', $request->input('password'));

                    // Создание и сохранение нового пользователя
                    $user = new User;
                    $user->login = $request->input('login');
                    $user->email = $request->input('email');
                    $user->first_name = $request->input('first_name');
                    $user->second_name = $request->input('second_name');
                    $user->third_name = $request->input('third_name');
                    $user->password_sha512 = $password_sha512;
                    $user->role_id = Role::ROLE_ID_USER; //!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    $user->last_activity_at = now();
                    $user->save();

                    Functions::saveSession($user);
                    return redirect()->route(Functions::ROUTE_NAME_TO_REDIRECT_FROM_AUTHORIZATION)->header('Content-Type', 'text/html');
                }
            }
            return response()
                ->view('registration.index', [
                    'form_data' => $request->only(['login', 'email', 'first_name', 'second_name', 'third_name', 'password', 'password_confirmed']),
                    'errors' => $errors
                ])
                ->header('Content-Type', 'text/html');
        }
    }
}
