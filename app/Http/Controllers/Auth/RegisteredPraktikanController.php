<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Asisten;
use App\Models\Praktikan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class RegisteredPraktikanController extends Controller
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
    public function store(Request $request)
    {
        
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'nim' => 'required|string|max:12|unique:' . Praktikan::class,
                'nomor_telepon' =>'required|string|max:15',
                'email' => 'required|string|email',
                'kelas_id'=>'required|integer|exists:kelas,id',
                'alamat' => 'required|string',
                'password' =>'required|string',
            ]);
            
            $praktikan = Praktikan::create([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'kelas_id' => $request->kelas_id,
                'alamat' => $request->alamat,
                'email' => $request->email,
                'nomor_telepon' => $request->nomor_telepon,
                'password' => Hash::make($request->password),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $praktikan->assignRole('PRAKTIKAN');
            
            Auth::login($praktikan);
            return "ini aman kan";
            
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
