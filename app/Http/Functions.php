<?php

namespace App\Http;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Functions
{
    /** Минимальная длина логина пользователя */
    public const MIN_LENGTH_LOGIN = 4;
    /** Максимальная длина логина пользователя */
    public const MAX_LENGTH_LOGIN = 64;

    /** Минимальная длина адреса электронной почты пользователя */
    public const MIN_LENGTH_EMAIL = 4;
    /** Максимальная длина адреса электронной почты пользователя */
    public const MAX_LENGTH_EMAIL = 64;

    /** Минимальная длина телефона пользователя */
    public const MIN_LENGTH_PHONE = 10;
    /** Максимальная длина телефона пользователя */
    public const MAX_LENGTH_PHONE = 11;

    /** Минимальная длина имени пользователя */
    public const MIN_LENGTH_FIRST_NAME = 2;
    /** Максимальная длина имени пользователя */
    public const MAX_LENGTH_FIRST_NAME = 32;

    /** Минимальная длина фамилии пользователя */
    public const MIN_LENGTH_SECOND_NAME = 2;
    /** Максимальная длина фамилии пользователя */
    public const MAX_LENGTH_SECOND_NAME = 32;

    /** Минимальная длина отчества пользователя */
    public const MIN_LENGTH_THIRD_NAME = 2;
    /** Максимальная длина отчества пользователя */
    public const MAX_LENGTH_THIRD_NAME = 32;

    /** Минимальная длина пароля пользователя */
    public const MIN_LENGTH_PASSWORD = 4;
    /** Максимальная длина пароля пользователя */
    public const MAX_LENGTH_PASSWORD = 128;

    public const ROUTE_NAME_TO_REDIRECT_FROM_AUTHORIZATION = 'index';
    public const ROUTE_NAME_TO_REDIRECT_FROM_DENY_ACCESS = 'index';

    // Типы значений настроек
    public const SETTING_VALUE_SHOW_TO_NOONE = 0;
    public const SETTING_VALUE_SHOW_TO_CONTACTS = 1;
    public const SETTING_VALUE_SHOW_TO_ALL = 2;

    // Типы институтов - предприятие или учебное заведение
    public const INSTITUTIONS_TYPE_PRACTIC = 0; // предприятие
    public const INSTITUTIONS_TYPE_STUDY = 1; // учебное заведение

    /** Часовой пояс для дат в БД */
    public const TIMEZONE_PRECISION = 3;

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
        else if($is_required && $text_length == 0)
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
