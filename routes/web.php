<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\RegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class, 'index']);

Route::get('/authorization', [AuthorizationController::class, 'index'])
    ->name('authorization');
Route::post('/authorization/checkForm', [AuthorizationController::class, 'checkForm']);

Route::get('/registration', [RegistrationController::class, 'index'])
    ->name('registration');
Route::post('/registration/checkForm', [RegistrationController::class, 'checkForm']);
