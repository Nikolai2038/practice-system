<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Functions;
use App\Models\User;
use Illuminate\Http\Request;

class InstitutionsController extends Controller
{
    public function index()
    {
        $total_user = Functions::getTotalUser();
        return response()->view('institutions.index', ['total_user' => $total_user])->header('Content-Type', 'text/html');
    }

    public function create(Request $request)
    {
        $total_user = Functions::getTotalUser();
        if ($request->isMethod('get'))
        {
            return response()->view('institutions.create', ['total_user' => $total_user])->header('Content-Type', 'text/html');
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
                    Functions::saveSession($user_found);
                    return redirect()->route(Functions::ROUTE_NAME_TO_REDIRECT_FROM_AUTHORIZATION)->header('Content-Type', 'text/html');
                }
            }
            return response()
                ->view('institutions.create', [
                    'form_data' => $request->only(['login', 'password']),
                    'errors' => $errors,
                    'total_user' => $total_user
                ])
                ->header('Content-Type', 'text/html');
        }
    }
}
