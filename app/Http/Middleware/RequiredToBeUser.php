<?php

namespace App\Http\Middleware;

use App\Http\Functions;
use Closure;
use Illuminate\Http\Request;

class RequiredToBeUser
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
        if($total_user == null) // если пользователь не авторизован
        {
            return redirect()->route('authorization')->header('Content-Type', 'text/html');
        }
        else
        {
            if($total_user->getActiveBan() != null) // если пользователь имеет активный бан - выкидываем его
            {
                Functions::deleteSession();
                return redirect()->route('authorization')->header('Content-Type', 'text/html');
            }
            else
            {
                return $next($request);
            }
        }
    }
}
