<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\FormFieldInput;
use App\Models\InstitutionType;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Functions;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AuthorizationController extends Controller
{
    public function index(Request $request)
    {
        $total_user = Functions::getTotalUser();

        $form_field_keys = array(
            FormFieldInput::FIELD_KEY_LOGIN,
            FormFieldInput::FIELD_KEY_PASSWORD
        );
        $form_field_defaults = null;
        $fields_options_values = null;
        $fields_options_values_guarded = null;
        $fields_options_names = null;
        $html_fields = FormFieldInput::generateHtmlFields($request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded, $fields_options_names);

        if ($request->isMethod('get'))
        {
            return response()->view('authorization.index', ['html_fields' => $html_fields, 'total_user' => $total_user])->header('Content-Type', 'text/html');
        }
        else if ($request->isMethod('post'))
        {
            $errors = array();

            FormFieldInput::checkInputs($errors, $request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded);

            if (count($errors) == 0)
            {
                $user_found = FormFieldInput::checkInputIsLoginOrPasswordWrong($request, $errors);

                if (count($errors) == 0)
                {
                    $active_ban = $user_found->getActiveBan();
                    if ($active_ban != null)
                    {
                        $error = 'Данный аккаунт заблокирован';
                        if ($active_ban->is_permanent)
                        {
                            $error .= ' навсегда!';
                        }
                        else
                        {
                            $error .= ' до ' . $active_ban->unban_at . '!';
                        }
                        $error .= ' Бан выдан администратором ' . $active_ban->user_from->getFullName() . '.';
                        $error .= ' Причина: ' . ($active_ban->description ?? 'не указана') . '.';
                        $errors[] = $error;
                    }
                }

                if (count($errors) == 0)
                {
                    Functions::saveSession($user_found);
                    return redirect()->route(Functions::ROUTE_NAME_TO_REDIRECT_FROM_AUTHORIZATION)->header('Content-Type', 'text/html');
                }
            }

            return response()
                ->view('authorization.index', [
                    'html_fields' => $html_fields,
                    'errors' => $errors,
                    'total_user' => $total_user
                ])
                ->header('Content-Type', 'text/html');
        }
    }
}
