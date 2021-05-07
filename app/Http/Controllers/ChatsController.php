<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Functions;

class ChatsController extends Controller
{
    public function index()
    {
        $total_user = Functions::getTotalUser();
        return response()->view('chats.index', ['total_user' => $total_user])->header('Content-Type', 'text/html');
    }
}
