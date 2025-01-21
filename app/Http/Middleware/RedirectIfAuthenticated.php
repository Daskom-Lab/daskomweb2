<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        $user = $request->user()->guard;
        switch ($user) {
            case 'asisten':
                return redirect()->route('assistant');
                break;
            case 'praktikan':
                return redirect()->route('dashboard');
                break;
            default:
                return $next($request);
                break;
        }

        return $next($request);
    }
}
