<?php

namespace App\Http\Middleware;

use Closure;

class CheckUser
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
        if ($request->session()->get('accessed_by') == 'user') {
            return $next($request);
        }

        return redirect()->route('login')->with('message', 'Você não tem acesso a essa área.');
    }
}
