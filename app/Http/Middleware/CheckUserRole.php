<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role = 'user')
    {
     
        if (!Auth::check()) {
            return redirect('/login'); 
        }

        $user = Auth::user();
       
        if ($user->role === $role) {
            return redirect('/'); 
        }

        return $next($request);
    }
}
