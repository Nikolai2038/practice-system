<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    public function index()
    {
        return response()->view('registration.index')->header('Content-Type', 'text/html');
    }

    public function checkForm()
    {
        return response()->view('registration.index')->header('Content-Type', 'text/html');
    }
}
