<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Functions;
use Illuminate\Support\Facades\Route;

class ChatsController extends Controller
{
    public function index()
    {
        $total_user = Functions::getTotalUser();
        return response()->view('chats.index', ['total_user' => $total_user])->header('Content-Type', 'text/html');
    }

    public function create($with_user_id)
    {
        $total_user = Functions::getTotalUser();
        return response()->view('chats.index', ['total_user' => $total_user])->header('Content-Type', 'text/html');
    }

    public function delete($with_user_id)
    {
        $total_user = Functions::getTotalUser();
        return response()->view('chats.index', ['total_user' => $total_user])->header('Content-Type', 'text/html');
    }

    public function view($chat_id)
    {
        $total_user = Functions::getTotalUser();
        return response()->view('chats.index', ['total_user' => $total_user])->header('Content-Type', 'text/html');
    }
}
