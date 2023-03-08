<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->is_employee) {
            return response()->json(['errors'=>['email'=>"You are not an employee"]])->setStatusCode(401);
        }else{
            return $next($request);
        }
    }
}
