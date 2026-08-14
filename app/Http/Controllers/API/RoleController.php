<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Asisten;
use App\PermissionGroupEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::guard('asisten')->check()) {
            $roles = Role::where('name', '!=', 'praktikan')
                ->get()
                ->makeHidden(['guard_name']);
        } else {
            $roles = Role::where('name', '!=', 'praktikan') // Exclude the 'praktikan' role
                ->whereNotIn('name', ['SOFTWARE', 'ADMIN', 'KORDAS', 'WAKORDAS', 'KOORPRAK', 'HARDWARE', 'DDC']) // Exclude specific roles
                ->get()
                ->makeHidden(['guard_name']);
        }

        return response()->json([
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $SUPER_PACKAGE = array_merge(
            PermissionGroupEnum::SUPER_ASLAB
        );

        $ASLAB_PACKAGE = array_merge(
            PermissionGroupEnum::ASLAB
        );

        $ATC_PACKAGE = array_merge(
            PermissionGroupEnum::ATC
        );

        $RDC_PACKAGE = array_merge(
            PermissionGroupEnum::RDC
        );

        $ASISTEN_PACKAGE = array_merge(
            PermissionGroupEnum::ASISTEN
        );

        try {
            $request->validate([
                'name' => 'required|string|unique:roles,name',
            ]);
            $data = request()->input('paket', []);

            if (empty($data)) {
                return redirect(route('manage-role'))->with('error', 'No data provided.');
            }

            $permissions = [];
            foreach ($data as $paket) {
                if (! in_array($paket, ['super', 'aslab', 'atc', 'rdc', 'asisten'])) {
                    return redirect(route('manage-role'))->with('error', 'Invalid package.');
                }

                switch ($paket) {
                    case 'super':
                        $permissions = array_merge($permissions, $SUPER_PACKAGE);
                        break;
                    case 'aslab':
                        $permissions = array_merge($permissions, $ASLAB_PACKAGE);
                        break;
                    case 'atc':
                        $permissions = array_merge($permissions, $ATC_PACKAGE);
                        break;
                    case 'rdc':
                        $permissions = array_merge($permissions, $RDC_PACKAGE);
                        break;
                    case 'asisten':
                        $permissions = array_merge($permissions, $ASISTEN_PACKAGE);
                        break;
                    default:
                        $permissions = [];
                        break;
                }
            }

            // Every asisten role needs manage-profile to land on /assistant after login,
            // regardless of which packages were selected (mirrors RolePermissionsSeeder,
            // where every seeded role has it).
            $permissions[] = PermissionGroupEnum::MANAGE_PROFILE;

            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'asisten',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $role->syncPermissions(array_unique($permissions));

            return redirect(route('manage-role'))->with('success', 'Role created successfully.');
        } catch (\Throwable $th) {
            return redirect(route('manage-role'))->with('error', $th->getMessage());
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
    public function update(Request $request, $idAsisten) // update role asisten
    {
        try {
            $request->validate([
                'role_id' => 'required|exists:roles,id',
            ]);
            $role = Role::findOrFail($request->role_id);
            $asisten = Asisten::where('kode', $idAsisten)->first();
            $oldRole = Role::findOrFail($asisten->role_id);
            $asisten->role_id = $request->role_id;
            $asisten->updated_at = now();
            $asisten->save();

            $asisten->removeRole($oldRole->name);
            $asisten->assignRole($role->name);

            return redirect(route('manage-role'))->with('success', 'Role updated successfully');
        } catch (\Throwable $th) {
            return redirect(route('manage-role'))->with('error', $th->getMessage());
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
