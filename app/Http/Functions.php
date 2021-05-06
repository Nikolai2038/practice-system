<?php

namespace App\Http;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Functions
{
    public const MIN_LENGTH_LOGIN = 4;
    public const MAX_LENGTH_LOGIN = 64;

    public const MIN_LENGTH_PASSWORD = 4;
    public const MAX_LENGTH_PASSWORD = 128;

    public const ROUTE_NAME_TO_REDIRECT_FROM_AUTHORIZATION = 'index';

    /** Функция проверки поля ввода */
    public static function checkInput(Request $request, $input_key, $input_name, $min_length, $max_length, $is_required = false, &$errors = null)
    {
        $text_length = strlen($request->input($input_key));

        if($is_required || $text_length > 0)
        {
            if(($text_length < $min_length) || ($text_length > $max_length))
            {
                $errors[] = 'Поле "'.$input_name.'" должно быть в диапазоне от '.$min_length.' до '.$max_length.' символов!';
            }
        }
        else
        {
            $errors[] = 'Поле "'.$input_name.'" должно быть заполнено!';
        }
    }

    /** Проверка авторизации текущего пользователя */
    public static function getTotalUser()
    {
        if(Session::has('user'))
        {
            $session_user = Session::get('user');
            $session_login = $session_user->login;
            $session_password_sha512 = $session_user->password_sha512;

            // Поиск пользователя в БД
            $found_user = User::where([
                ['login', '=', $session_login],
                ['password_sha512', '=', $session_password_sha512],
            ])->first();

            // Если пользователь найден - обновляем сессию
            if($found_user != null)
            {
                $found_user->last_activity_at = now(); // обновляем дату последней активности
                $found_user->save();
                Session::put('user', $found_user); // обновляем данные о пользователе
                return $found_user;
            }
            else
            {
                Session::flush(); // очищаем сессию
                return null;
            }
        }
        else
        {
            return null;
        }
    }

    /** Сохранение сессии */
    public static function saveSession(User $user)
    {
        $total_user = self::getTotalUser();
        if($total_user == null) // (в случае если не равно null, то всё равно сессия обновит свои данные в методе getTotalUser())
        {
            $user->last_activity_at = now();
            $user->save();
            Session::put('user', $user); // обновляем данные о пользователе
        }
    }

    /** Сохранение сессии */
    public static function deleteSession()
    {
        $total_user = self::getTotalUser(); // вызываем для обновления активности пользователя
        Session::flush(); // очищаем сессию
    }
}
