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

class RolesController extends Controller
{
    public function index()
    {
        $total_user = Functions::getTotalUser();
        return response()->view('roles.index', ['total_user' => $total_user])->header('Content-Type', 'text/html');
    }

    public function edit(Request $request, $user_id)
    {
        $total_user = Functions::getTotalUser();
        $watching_user = User::where('id', '=', $user_id)->firstOrFail();

        if($total_user->canChangeRoleOfUser($watching_user) == false) // если у пользователя недостаточно прав для изменения роли указанного пользователя
        {
            return redirect()->route('administration_roles')->header('Content-Type', 'text/html');
        }
        else
        {
            $form_field_keys = array(
                FormFieldInput::FIELD_KEY_ROLE_ID,
            );
            $form_field_defaults = array(
                FormFieldInput::FIELD_KEY_ROLE_ID => $watching_user->role->id,
            );
            $fields_options_values = array(
                FormFieldInput::FIELD_KEY_ROLE_ID => FormFieldInput::generateOneFieldArray(Role::all('id as value')->toArray()),
            );
            $fields_options_values_guarded = array(
                FormFieldInput::FIELD_KEY_ROLE_ID => FormFieldInput::generateOneFieldArray(Role::where('weight', '>=', $total_user->role->weight)->select('id as value')->get()->toArray()),
            );
            $fields_options_names = array(
                FormFieldInput::FIELD_KEY_ROLE_ID => FormFieldInput::generateOneFieldArray(Role::all('name as value')->toArray()),
            );
            $html_fields = FormFieldInput::generateHtmlFields($request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded, $fields_options_names);

            $notification = null;
            $errors = null;

            if ($request->isMethod('post'))
            {
                $errors = array();

                FormFieldInput::checkInputs($errors, $request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded);

                if (count($errors) == 0)
                {
                    try
                    {
                        $new_role_id = $request->input(FormFieldInput::FIELD_KEY_ROLE_ID);
                        $new_role = Role::where('id', '=', $new_role_id)->first();
                        $watching_user->role()->associate($new_role);
                        $watching_user->save();
                        $notification = 'Роль успешно изменена!';
                    }
                    catch (\Exception $exception)
                    {
                        $errors[] = $exception->getMessage();
                    }
                }
            }

            return response()->view('roles.edit', [
                'html_fields' => $html_fields,
                'total_user' => $total_user,
                'watching_user' => $watching_user,
                'notification' => $notification,
                'errors' => $errors
            ])->header('Content-Type', 'text/html');
        }
    }
}
