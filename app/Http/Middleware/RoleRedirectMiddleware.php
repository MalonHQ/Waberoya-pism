<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirectMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Kama mtumiaji hajalogin kabisa
        if (! $user) {
            if ($request->is('logout') || $request->is('login') || $request->is('*/login') || $request->is('*login*')) {
                return $next($request);
            }

            if ($request->is('student*') || $request->is('lecturer*') || $request->is('admin*')) {
                return redirect('/admin/login');
            }

            return $next($request);
        }

        // Ruhusu kurasa za logout zipite bila bug yoyote
        if ($request->is('*/logout') || $request->is('logout')) {
            return $next($request);
        }

        // Uelekezo kulingana na Role (Hakikisha hauingii kwenye loop)
        if ($user->hasRole('student') && ! $request->is('student*')) {
            return redirect()->to('/student');
        }

        if ($user->hasRole('lecturer') && ! $request->is('lecturer*')) {
            return redirect()->to('/lecturer');
        }

        if (($user->hasRole('admin') || $user->email === 'admin@waberoya.co.tz') && ! $request->is('admin*')) {
            return redirect()->to('/admin');
        }

        return $next($request);
    }
}