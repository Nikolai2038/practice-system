<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Functions;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AdministrationController extends Controller
{
    public function index()
    {
        $total_user = Functions::getTotalUser();
        return response()->view('administration.index', ['total_user' => $total_user])->header('Content-Type', 'text/html');
    }

    public function roles()
    {
        $total_user = Functions::getTotalUser();
        return response()->view('administration.roles', ['total_user' => $total_user])->header('Content-Type', 'text/html');
    }

    public function edit(Request $request, $user_id)
    {
        $total_user = Functions::getTotalUser();
        $watching_user = User::where('id', '=', $user_id)->first();
        if($total_user->canChangeRoleOfUser($watching_user) == false) // если у пользователя недостаточно прав для изменения роли указанного пользователя
        {
            return redirect()->route('administration_roles')->header('Content-Type', 'text/html');
        }
        else
        {
            $notification = null;
            $errors = null;

            if ($request->isMethod('post'))
            {
                $new_role_id = $request->input('role');
                $new_role = Role::where('id', '=', $new_role_id)->first();
                if($total_user->canChangeRoleTo($new_role))
                {
                    $watching_user->role()->associate($new_role);
                    $watching_user->save();
                    $notification = 'Роль успешно изменена!';
                }
                else // если указанная роль превышает по полномочиям роль текущего пользователя
                {
                    $errors[] = 'Вы можете назначить только роли, выше которых находитесь сами!';
                }
            }

            $roles = Role::all();
            return response()->view('administration.edit', [
                'total_user' => $total_user,
                'watching_user' => $watching_user,
                'roles' => $roles,
                'notification' => $notification,
                'errors' => $errors
            ])->header('Content-Type', 'text/html');
        }
    }
}
