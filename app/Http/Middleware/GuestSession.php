<?php

namespace App\Http\Middleware;

use Closure;

class GuestSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->has('token') || !$request->session()->has('user') || !$request->session()->has('accessed_by')) {
            $request->session()->forget('token');
            $request->session()->forget('user');
            $request->session()->forget('accessed_by');

            return $next($request);
        }

        if ($request->session()->get('accessed_by') == 'user')
            return redirect()->route('user.home');
    }
}
