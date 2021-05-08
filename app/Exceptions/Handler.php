<?php

namespace App\Exceptions;

use App\Http\Functions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $total_user = Functions::getTotalUser();
        if ($e instanceof NotFoundHttpException) // маршрут не найден
        {
            // Не работает, так как сессия недоступна при неправильном указании маршрута - решение пока не нашёл
            // return response()->view('errors.404', ['total_user' => $total_user, 'description' => 'Маршрут не найден.'])->header('Content-Type', 'text/html');

            return redirect()->route(Functions::ROUTE_NAME_TO_REDIRECT_FROM_DENY_ACCESS)->header('Content-Type', 'text/html');
        }
        else if ($e instanceof ModelNotFoundException) // модель не найдена
        {
            return response()->view('errors.404', ['total_user' => $total_user, 'description' => 'Модель не найдена.'])->header('Content-Type', 'text/html');
        }
        return parent::render($request, $e);
    }

}
