<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\PracticesController;
use App\Http\Controllers\ChatsController;

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

// Главная
Route::get('/', [MainController::class, 'index'])
    ->name('index');

// Авторизация
Route::get('/authorization', [AuthorizationController::class, 'index'])
    ->name('authorization')
    ->middleware('required_to_be_guest');

// Авторизация - отправка формы
Route::post('/authorization', [AuthorizationController::class, 'index'])
    ->middleware('required_to_be_guest');

// Регистрация
Route::get('/registration', [RegistrationController::class, 'index'])
    ->name('registration')
    ->middleware('required_to_be_guest');

// Регистрация - отправка формы
Route::post('/registration', [RegistrationController::class, 'index'])
    ->middleware('required_to_be_guest');

// Выход из аккаунта
Route::get('/logout', [MainController::class, 'logout'])
    ->name('logout')
    ->middleware('required_to_be_user');

// Список пользователей
Route::get('/users', [UsersController::class, 'all'])
    ->name('users')
    ->middleware('required_to_be_user');

// Профиль пользователя (если ID не указан - показывается профиль текущего пользователя)
Route::get('/users/profile/{id?}', [UsersController::class, 'profile'])
    ->name('profile')
    ->middleware('required_to_be_user')
    ->where('id', '[0-9]+');

// Панель управления - регистрация новых пользователей
Route::get('/register', [MainController::class, 'register'])
    ->name('register')
    ->middleware('required_to_be_user', 'required_to_be_director');

// Настройки
Route::get('/settings', [SettingsController::class, 'index'])
    ->name('settings')
    ->middleware('required_to_be_user');

// Панель администратора - баны и т.п.
Route::get('/administration', [AdministrationController::class, 'index'])
    ->name('administration')
    ->middleware('required_to_be_user', 'required_to_be_administrator');

// Роли
Route::get('/administration/roles', [AdministrationController::class, 'roles'])
    ->name('administration_roles')
    ->middleware('required_to_be_user', 'required_to_be_administrator');

// Изменение роли пользователя
Route::get('/administration/roles/edit/{user_id}', [AdministrationController::class, 'edit'])
    ->name('administration_roles_edit')
    ->middleware('required_to_be_user', 'required_to_be_administrator')
    ->where('user_id', '[0-9]+');

Route::post('/administration/roles/edit/{user_id}', [AdministrationController::class, 'edit'])
    ->middleware('required_to_be_user', 'required_to_be_administrator')
    ->where('user_id', '[0-9]+');

// Контакты, запросы в друзья и т.п.
Route::get('/contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('required_to_be_user');

// Панель практик - создание, просмотр и т.п.
Route::get('/practices', [PracticesController::class, 'index'])
    ->name('practices')
    ->middleware('required_to_be_user');

// Панель чатов - все чаты, с разделением на группы
Route::get('/chats', [ChatsController::class, 'index'])
    ->name('chats')
    ->middleware('required_to_be_user');
