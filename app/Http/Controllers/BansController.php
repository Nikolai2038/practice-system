<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\FormFieldInput;
use App\Http\Functions;
use App\Models\Ban;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BansController extends Controller
{
    public function index()
    {
        $total_user = Functions::getTotalUser();
        $bans = Ban::orderByDesc('unban_at')->paginate(5);
        return response()->view('bans.index', ['total_user' => $total_user, 'bans' => $bans])->header('Content-Type', 'text/html');
    }

    public function view($user_id)
    {
        $total_user = Functions::getTotalUser();
        $watching_user = User::findOrFail($user_id);
        $bans = $watching_user->bans_to()->orderByDesc('unban_at')->paginate(5);
        return response()->view('bans.view', ['total_user' => $total_user, 'watching_user' => $watching_user, 'bans' => $bans])->header('Content-Type', 'text/html');
    }

    public function create(Request $request, $user_to_id)
    {
        $total_user = Functions::getTotalUser();
        $watching_user = User::findOrFail($user_to_id);

        $form_field_keys = array(
            FormFieldInput::FIELD_KEY_BAN_DESCRIPTION,
            FormFieldInput::FIELD_KEY_BAN_IS_PERMANENT,
            FormFieldInput::FIELD_KEY_BAN_UNBAN_AT,
        );
        $form_field_defaults = array(
            FormFieldInput::FIELD_KEY_BAN_UNBAN_AT => now()->addDay(1)->toDateTimeString()
        );
        $fields_options_values = array(
            FormFieldInput::FIELD_KEY_BAN_IS_PERMANENT => array(0, 1),
        );
        $fields_options_values_guarded = null;
        $fields_options_names = array(
            FormFieldInput::FIELD_KEY_BAN_IS_PERMANENT => array('Нет', 'Да'),
        );
        $html_fields = FormFieldInput::generateHtmlFields($request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded, $fields_options_names);

        if ($request->isMethod('get'))
        {
            return response()->view('bans.create', ['html_fields' => $html_fields, 'total_user' => $total_user, 'watching_user' => $watching_user])->header('Content-Type', 'text/html');
        }
        else if ($request->isMethod('post'))
        {
            $errors = array();

            FormFieldInput::checkInputs($errors, $request, $form_field_keys, $form_field_defaults, $fields_options_values, $fields_options_values_guarded);

            if (count($errors) == 0)
            {
                if($watching_user->getActiveBan() != null)
                {
                    $errors[] = 'Пользователь уже имеет действующий бан!';
                }
                else
                {
                    $unban_at = $request->input(FormFieldInput::FIELD_KEY_BAN_UNBAN_AT);

                    try{
                        $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $unban_at);
                    }
                    catch (\Exception $exception)
                    {
                        $errors[] = 'Неверный формат даты и времени! Введите дату и время в формате по примеру: '.now()->addDay(1)->toDateTimeString().'.';
                    }

                    if(count($errors) == 0)
                    {
                        try
                        {
                            $ban = new Ban;
                            $ban->user_from()->associate($total_user);
                            $ban->user_to()->associate($watching_user);
                            $ban->description = $request->input(FormFieldInput::FIELD_KEY_BAN_DESCRIPTION);
                            $ban->is_permanent = $request->input(FormFieldInput::FIELD_KEY_BAN_IS_PERMANENT);
                            $ban->unban_at = $unban_at;
                            $ban->save();
                            return redirect()->route('bans_view', $watching_user->id)->header('Content-Type', 'text/html');
                        }
                        catch (\Exception $exception)
                        {
                            $errors[] = $exception->getMessage();
                        }
                    }
                }
            }
            return response()
                ->view('bans.create', [
                    'html_fields' => $html_fields,
                    'errors' => $errors,
                    'watching_user' => $watching_user,
                    'total_user' => $total_user
                ])
                ->header('Content-Type', 'text/html');
        }
    }

    public function unban(Request $request, $ban_id)
    {
        $total_user = Functions::getTotalUser();
        $ban = Ban::find($ban_id);
        $watching_user = $ban->user_to;
        if($total_user->canUnbanBan($ban) == false)
        {
            return redirect()->route('bans_view', $watching_user->id)->header('Content-Type', 'text/html');
        }
        else
        {
            if ($request->isMethod('get'))
            {
                return response()->view('bans.unban', ['total_user' => $total_user, 'ban' => $ban])->header('Content-Type', 'text/html');
            }
            else if ($request->isMethod('post'))
            {
                $ban->unban_at = now()->toDateTimeString();
                if ($ban->is_permanent)
                {
                    $ban->is_permanent = false;
                }
                $ban->save();
                return redirect()->route('bans_view', $watching_user->id)->header('Content-Type', 'text/html');
            }
        }
    }

    public function delete(Request $request, $ban_id)
    {
        $total_user = Functions::getTotalUser();
        $ban = Ban::find($ban_id);
        $watching_user = $ban->user_to;
        if($total_user->canDeleteBan($ban) == false)
        {
            return redirect()->route('bans_view', $watching_user->id)->header('Content-Type', 'text/html');
        }
        else
        {
            if ($request->isMethod('get'))
            {
                return response()->view('bans.delete', ['total_user' => $total_user, 'ban' => $ban])->header('Content-Type', 'text/html');
            }
            else if ($request->isMethod('post'))
            {
                $ban->delete();
                return redirect()->route('bans_view', $watching_user->id)->header('Content-Type', 'text/html');
            }
        }
    }
}
