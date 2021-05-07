<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Functions;

class MainController extends Controller
{
    public function index()
    {
        $total_user = Functions::getTotalUser();
        return response()->view('main.index', ['total_user' => $total_user])->header('Content-Type', 'text/html');
    }

    public function logout()
    {
        Functions::deleteSession();
        return redirect()->route('authorization')->header('Content-Type', 'text/html');
    }

    public function register()
    {
        $total_user = Functions::getTotalUser();
        return response()->view('main.register', ['total_user' => $total_user])->header('Content-Type', 'text/html');
    }
}
