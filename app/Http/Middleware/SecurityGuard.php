<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityGuard
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
        if (auth()->user()->is_security_guard ) {
            return $next($request);
        } else {
            abort(403, "You are not part of the security team of this Organization currently");
        }
    }
}
