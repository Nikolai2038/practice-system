<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

class AuthorizationController extends Controller
{
    public function index()
    {
        return response()->view('authorization.index')->header('Content-Type', 'text/html');
    }

    public function checkForm()
    {
        return response()->view('authorization.index')->header('Content-Type', 'text/html');
    }
}
