<?php

namespace App\Http\Middleware;

use App\Http\Functions;
use Closure;
use Illuminate\Http\Request;

class RequiredToBeGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $total_user = Functions::getTotalUser();
        if($total_user != null) // если пользователь авторизован
        {
            return redirect()->route(Functions::ROUTE_NAME_TO_REDIRECT_FROM_AUTHORIZATION)->header('Content-Type', 'text/html');
        }
        else
        {
            return $next($request);
        }
    }
}
