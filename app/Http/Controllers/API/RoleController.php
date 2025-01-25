<?php

namespace App\Http\Controllers\API;

use App\Models\Asisten;
use App\PermissionGroupEnum;
use Illuminate\Http\Request;
use App\Models\Role as roles;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $roles = Role::where('name', '!=', 'praktikan') // Exclude the 'praktikan' role
        ->whereNotIn('name', ['SOFTWARE', 'ADMIN', 'KORDAS', 'WAKORDAS', 'KOORPRAK', 'HARDWARE', 'DDC']) // Exclude specific roles
        ->get()
        ->makeHidden(['guard_name']);

        return response()->json([
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $SUPER_PACKAGE = array_merge(
            PermissionGroupEnum::SUPER_ASLAB,
            PermissionGroupEnum::ASLAB,
            PermissionGroupEnum::ATC,
            PermissionGroupEnum::RDC,
            PermissionGroupEnum::ASISTEN
        );

        $ASLAB_PACKAGE = array_merge(
            PermissionGroupEnum::ASLAB,
            PermissionGroupEnum::ATC,
            PermissionGroupEnum::RDC,
            PermissionGroupEnum::ASISTEN
        );

        $ATC_PACKAGE = array_merge(
            PermissionGroupEnum::ATC,
            PermissionGroupEnum::ASISTEN
        );

        $RDC_PACKAGE = array_merge(
            PermissionGroupEnum::RDC,
            PermissionGroupEnum::ASISTEN
        );

        $ASISTEN_PACKAGE = array_merge(
            PermissionGroupEnum::ASISTEN
        );

        try {
            $request->validate([
                'name' => 'required|string',
                'paket' => 'required|string',
            ]);

            switch ($request->paket) {
                case 'super':
                    $permissions = $SUPER_PACKAGE;
                    break;
                case 'aslab':
                    $permissions = $ASLAB_PACKAGE;
                    break;
                case 'atc':
                    $permissions = $ATC_PACKAGE;
                    break;
                case 'rdc':
                    $permissions = $RDC_PACKAGE;
                    break;
                case 'asisten':
                    $permissions = $ASISTEN_PACKAGE;
                    break;
                default:
                    $permissions = [];
                    break;
            }

            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'asisten',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $role->syncPermissions($permissions);

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully',
                'data' => $role
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
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
    public function update(Request $request, $idAsisten) //update role asisten
    {
        try {
            $request->validate([
                'role_id' => 'required|exists:roles,id',
            ]);
            $role = Role::findOrFail($request->role_id);
            $asisten = Asisten::findOrFail($idAsisten);
            $oldRole = Role::findOrFail($asisten->role_id);
            $asisten->role_id = $request->role_id;
            $asisten->updated_at = now();
            $asisten->save();

            $asisten->removeRole($oldRole->name);
            $asisten->assignRole($role->name);

            return response()->json([
                'success' => true,
                'message' => 'Asisten role updated successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
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
