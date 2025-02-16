<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and determine their guard
        $asisten = Auth::guard('asisten')->check() ? 'asisten' : null;
        $praktikan = Auth::guard('praktikan')->check() ? 'praktikan' : null;

        // Check the user's guard and redirect accordingly
        if ($asisten) {
            return redirect()->route('assistant'); 
        }
            
        if ($praktikan) {
            return redirect()->route('praktikan'); 
        }

        return $next($request);
    }
}
