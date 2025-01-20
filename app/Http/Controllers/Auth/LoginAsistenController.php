<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Asisten;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\Auth\AsistenLoginRequest;
use Spatie\Permission\Models\Role;

class LoginAsistenController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [ //ini gantii yahh
            // data that u wanna pass
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(AsistenLoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        $user = Auth::guard('asisten')->user(); // Get the authenticated user object
        $role = Role::find($user->role_id);
        $permissions = $role->permissions; // Assuming this fetches the permissions
        $allPermissions = $role->permissions->pluck('name'); // Extract permissions
     

        $token = $user->createToken($role->name, [...$allPermissions ])->plainTextToken; // Generate a new token
        
        return response()->json([
            'token' => $token,
            'asisten' => $user
        ]);

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('asisten')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    
}
