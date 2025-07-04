<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SelectMonth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('yearmonth')) {
            return redirect()->route('admin.select-month')->with('error', 'Please select a month to continue');
        }

        // Ensure the session has a valid date format
        $date = $request->session()->get('yearmonth');
        if (!\Carbon\Carbon::createFromFormat('Y-m', $date)) {
            return redirect()->route('admin.select-month')->with('error', 'Invalid month format in session');
        }

        return $next($request);
    }
}
