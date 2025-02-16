<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Asisten;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class RegisteredAsistenController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');//ini pake path yg bener
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request):RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|uppercase|max:3|unique:' . Asisten::class,
            'role_id'=>'required|integer|exists:roles,id', 
            'nomor_telepon' =>'required|string|max:15',
            'id_line' => 'required|string',
            'instagram' => 'required|string',
            'deskripsi' => 'required|string',
            'password' =>'required|string',
        ]);

        $asisten = Asisten::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'role_id' => $request->role_id,
            'nomor_telepon' => $request->nomor_telepon,
            'id_line' => $request->id_line,
            'instagram' => $request->instagram,
            'deskripsi' => $request->deskripsi, 
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $role = Role::findOrFail($request->role_id);

        $asisten->assignRole($role->name);

        return Redirect::route('login');
    }
}
