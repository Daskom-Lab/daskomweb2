<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Asisten;
use App\Models\Configuration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class RegisteredAsistenController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register'); // ini pake path yg bener
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            // Check if assistant registration is enabled
            $config = Configuration::first();
            if (!$config?->registrationAsisten_activation) {
                return redirect()->back()->with('error', 'Assistant registration is currently disabled.');
            }

            // Validate input
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kode' => 'required|string|uppercase|max:3|unique:asistens,kode',
                'role_id' => 'required|integer|exists:roles,id',
                'nomor_telepon' => 'required|string|max:15',
                'id_line' => 'required|string',
                'instagram' => 'required|string',
                'deskripsi' => 'required|string',
                'password' => 'required|string',
            ]);

            // Create new Asisten
            $asisten = Asisten::create([
                'nama' => $validated['nama'],
                'kode' => $validated['kode'],
                'role_id' => $validated['role_id'],
                'nomor_telepon' => $validated['nomor_telepon'],
                'id_line' => $validated['id_line'],
                'instagram' => $validated['instagram'],
                'deskripsi' => $validated['deskripsi'],
                'password' => Hash::make($validated['password']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Assign role
            $role = Role::findOrFail($validated['role_id']);
            $asisten->assignRole($role->name);

            return redirect('/register?mode=assistant')->with('success', 'Asisten registered successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating asisten: '.$e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}
