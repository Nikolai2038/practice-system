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
        $total_user->checkUserPermissionsToUsers($users);
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
        $total_user->checkUserPermissionsToUser($watching_user);
        $contact_to_watching_user = $total_user->getContactRequestWithUser($watching_user);
        return response()->view('users.profile', [
            'total_user' => $total_user,
            'watching_user' => $watching_user,
            'contact_to_watching_user' => $contact_to_watching_user
        ])->header('Content-Type', 'text/html');
    }
}
