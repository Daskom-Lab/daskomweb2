<?php

namespace App\Http\Middleware;

use Closure;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }
        return redirect()->route('/');
    }
}
