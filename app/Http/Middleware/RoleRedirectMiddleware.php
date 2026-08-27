<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirectMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user) {
            // Kama ni Student lakini yupo nje ya panel ya /student
            if ($user->hasRole('student') && ! $request->is('student*')) {
                return redirect('/student');
            }

            // Kama ni Lecturer lakini yupo nje ya panel ya /lecturer
            if ($user->hasRole('lecturer') && ! $request->is('lecturer*')) {
                return redirect('/lecturer');
            }

            // Kama ni Admin lakini yupo kwenye panel za mwanafunzi au mwalimu
            if ($user->hasRole('admin') && ! $request->is('admin*')) {
                return redirect('/admin');
            }
        }

        return $next($request);
    }
}