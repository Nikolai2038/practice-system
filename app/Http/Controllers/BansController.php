<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Functions;

class BansController extends Controller
{
    public function index()
    {
        $total_user = Functions::getTotalUser();
        return response()->view('bans.index', ['total_user' => $total_user])->header('Content-Type', 'text/html');
    }
}
