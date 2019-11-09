<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if(Auth::user()->person->role->name == "Superadmin" || Auth::user()->person->role->name == "Administrador"){
                return redirect('/products');
            }elseif (Auth::user()->person->role->name == "Cliente"){
                return redirect('/');
            }else{
                return redirect('/sales');
            }        
        }

        return $next($request);
    }
}
