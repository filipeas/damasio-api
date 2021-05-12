<?php

namespace App\Http\Middleware;

use Closure;

class CheckSession
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
        if ($request->session()->has('token') && $request->session()->has('user') && $request->session()->has('accessed_by'))
            return $next($request);

        return redirect()->route('login')->with('message', 'Sua sessão expirou. Por favor, faça login novamente.');
    }
}
