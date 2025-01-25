<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, array $permissions): Response
    {
        // Check if the user is authenticated as 'asisten'
        if (Auth::guard('asisten')->check()) {
            $user = Auth::guard('asisten')->user();

            // Get the user's role permissions
            $userRolePermissions = $user->role->permissions->pluck('name')->toArray();

            // Check if the required permission exists in the user's permissions
            foreach ($permissions as $permission) {
                if (in_array($permission, $userRolePermissions)) {
                    return $next($request); // Permission granted
                }
            }
        }

        // Check if the user is authenticated as 'praktikan'
        if (Auth::guard('praktikan')->check()) {
            $user = Auth::guard('praktikan')->user();

            // Get the user's role permissions
            $userRolePermissions = $user->role->permissions->pluck('name')->toArray();

            // Check if the required permission exists in the user's permissions
            foreach ($permissions as $permission) {
                if (in_array($permission, $userRolePermissions)) {
                    return $next($request); // Permission granted
                }
            }
        }

        // Redirect the user if unauthorized
        return redirect('/');
    }

}
