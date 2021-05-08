<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Functions;
use App\Models\User;

class UsersController extends Controller
{
    public function all()
    {
        $total_user = Functions::getTotalUser();
        $users = User::orderBy('id')->paginate(10);
        foreach ($users as $user)
        {
            if($user->canShowEmailTo($total_user) == false)
            {
                $user['email'] = 'Скрыт';
            }
            if($user->canShowPhoneTo($total_user) == false)
            {
                $user['phone'] = 'Скрыт';
            }
        }
        return response()->view('users.all', ['total_user' => $total_user, 'users' => $users])->header('Content-Type', 'text/html');
    }

    public function profile($user_id = null)
    {
        $total_user = Functions::getTotalUser();
        $watching_user = $total_user;
        if($user_id != null)
        {
            $watching_user = User::where('id', '=', $user_id)->firstOrFail();
        }
        return response()->view('users.profile', ['total_user' => $total_user, 'watching_user' => $watching_user])->header('Content-Type', 'text/html');
    }
}
