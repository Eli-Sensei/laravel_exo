<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Redac
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // $user = $request->user();
        // if($user && $user->role === "admin" || $user->role === "redac"){
        //     return $next($request);
        // }

        // return redirect()->route("home");
        return $next($request);
    }
}
