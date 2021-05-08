<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Functions;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AdministrationController extends Controller
{
    public function index()
    {
        $total_user = Functions::getTotalUser();
        return response()->view('administration.index', ['total_user' => $total_user])->header('Content-Type', 'text/html');
    }
}
