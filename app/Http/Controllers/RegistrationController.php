<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Functions;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('get'))
        {
            return response()->view('registration.index')->header('Content-Type', 'text/html');
        }
        else if ($request->isMethod('post'))
        {
            $errors = array();

            Functions::checkInput($request, 'login', 'Логин', Functions::MIN_LENGTH_LOGIN, Functions::MAX_LENGTH_LOGIN, true, $errors);
            Functions::checkInput($request, 'password', 'Пароль', Functions::MIN_LENGTH_PASSWORD, Functions::MAX_LENGTH_PASSWORD, true, $errors);

            if (count($errors) == 0)
            {
                $password_sha512 = hash('sha512', $request->input('password'));
                $user_found = User::where([
                    ['login', '=', $request->input('login')],
                    ['password_sha512', '=', $password_sha512],
                ])->first();

                if ($user_found == null)
                {
                    $errors[] = 'Неверный логин или пароль!';
                }
                else
                {
                    // АВТОРИЗАЦИЯ
                    // СОХРАНЕНИЕ СЕССИИ


                    return redirect()->route(Functions::ROUTE_NAME_TO_REDIRECT_FROM_AUTHORIZATION)->header('Content-Type', 'text/html');
                }
            }
            return response()->view('registration.index', ['form_data' => $request->only(['login', 'password']), 'errors' => $errors])->header('Content-Type', 'text/html');
        }
    }
}
