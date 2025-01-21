<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use PSpell\Config;

class ConfigurationController extends Controller
{
    /**
     * ALL CONF GOES HERE web conf, TP conf, Unlock ans conf
     */
    public function index()
    {
        try {
            $config = Configuration::select(
                'tp_activation',
                'tubes_activation',
                'polling_activation',
                'registrationPraktikan_activation', 
                'registrationAsisten_activation',
                'kode_asisten'
            )->first();
            return response()->json([
                'success' => true,
                'config' => $config,
                'message' => 'Configuration retrieved successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve configuration.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $config = Configuration::first();
            if (!$config) {
                return response()->json([
                    'success' => false,
                    'message' => 'Configuration not found.'
                ], 404);
            }
            $request->validate([
                'tp_activation' => 'required|integer',
                'tubes_activation' => 'required|integer',
                'polling_activation' => 'required|integer',
                'registrationPraktikan_activation' => 'required|integer',
                'registrationAsisten_activation' => 'required|integer',
                'kode_asisten' => 'required|string',
            ]);
            $config->tp_activation = $request->tp_activation;
            $config->tubes_activation = $request->tubes_activation;
            $config->polling_activation = $request->polling_activation;
            $config->secretfeature_activation = $request->secretfeature_activation;
            $config->registrationPraktikan_activation = $request->registrationPraktikan_activation;
            $config->registrationAsisten_activation = $request->registrationAsisten_activation;
            $config->kode_asisten = $request->kode_asisten ?? auth('sanctum')->user()->kode;
            $config->save();
            return response()->json([
                'config' => $config,
                'success' => true,
                'message' => 'Configuration updated successfully.'
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update configuration.',
                'error' => $e->getMessage()
            ], 500);
        }
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
