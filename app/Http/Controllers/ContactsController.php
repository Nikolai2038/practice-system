<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Functions;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ContactsController extends Controller
{
    public function index()
    {
        $total_user = Functions::getTotalUser();
        $users = $total_user->getAllContacts();
        return response()->view('contacts.index', ['total_user' => $total_user, 'users' => $users])->header('Content-Type', 'text/html');
    }

    public function incoming()
    {
        $total_user = Functions::getTotalUser();
        $users = $total_user->getIncomingContacts();
        return response()->view('contacts.incoming', ['total_user' => $total_user, 'users' => $users])->header('Content-Type', 'text/html');
    }

    public function outcoming()
    {
        $total_user = Functions::getTotalUser();
        $users = $total_user->getOutcomingContacts();
        return response()->view('contacts.outcoming', ['total_user' => $total_user, 'users' => $users])->header('Content-Type', 'text/html');
    }

    public function create(Request $request, $with_user_id, $came_from_route_name)
    {
        $came_from_route_params = $request->input();
        $total_user = Functions::getTotalUser();
        $watching_user = User::findOrFail($with_user_id);
        $contact = $total_user->getContactRequestWithUser($watching_user);
        if($contact == null) // если заявки между пользователями ещё не было
        {
            $contact = new Contact;
            $contact->user_from()->associate($total_user);
            $contact->user_to()->associate($watching_user);
            $contact->save();
        }
        else if(($contact->is_accepted == false) && ($contact->user_to->id == $total_user->id)) // если заявка была текущему пользователю, но не была принята
        {
            $contact->is_accepted = true;
            $contact->save();
        }
        return redirect()->route($came_from_route_name, $came_from_route_params)->header('Content-Type', 'text/html');
    }

    public function delete(Request $request, $with_user_id, $came_from_route_name)
    {
        $came_from_route_params = $request->input();
        $total_user = Functions::getTotalUser();
        $watching_user = User::findOrFail($with_user_id);
        $contact = $total_user->getContactRequestWithUser($watching_user);
        if($contact != null) // если заявка между пользователями существует
        {
            $contact->delete(); // удаляем заявку
        }
        return redirect()->route($came_from_route_name, $came_from_route_params)->header('Content-Type', 'text/html');
    }
}
