<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permissions\CreatePermissionRequest;
use App\Http\Requests\Permissions\GetPermissionsRequest;
use App\Http\Requests\Permissions\UpdatePermissionRequest;
use App\Http\Resources\Permissions\PermissionsCollection;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermissionsController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:sanctum');
//        $this->middleware('role:super.admin');
//
//
//        try {
//            ob_start('ob_gzhandler');
//        } catch (\Exception $e) {
//            //
//        }
//    }

    public function permissions(GetPermissionsRequest $request)
    {
        return new PermissionsCollection(config('roles.models.permission')::all());
    }

    public function getPermissions()
    {
        $userId = auth()->user()->id;

        return DB::table('permissions')
            ->join('permission_role', 'permissions.id', '=', 'permission_role.permission_id')
            ->join('roles', 'permission_role.role_id', '=', 'roles.id')
            ->join('role_user', 'roles.id', '=', 'role_user.role_id')
            ->where('role_user.user_id', $userId)
            ->select('permissions.id', 'permissions.name', 'permissions.slug', 'permissions.description', 'permissions.model', DB::raw('GROUP_CONCAT(roles.name) as role_names'))
            ->groupBy('permissions.id', 'permissions.name', 'permissions.slug', 'permissions.description', 'permissions.model')
            ->get();
    }


    public function permissionsPaginated(GetPermissionsRequest $request)
    {
        $per = 10;

        if ($request->has('per')) {
            $per = $request->input('per');
        }

        return response()->json(Permission::with([
            'users:name,id,email',
            'roles:id,name',
        ])->paginate($per));
    }

    public function createPermission(CreatePermissionRequest $request)
    {
        $validated = $request->validated();

        $permission = Permission::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'model' => $validated['model'],
        ]);

        if ($permission) {
            $permission->roles()->sync($validated['roles']);
        }

        $permission->load([
            'users:name,id,email',
            'roles:id,name',
        ]);

        return response()->json([
            'permission' => $permission,
        ]);
    }

    public function updatePermission(UpdatePermissionRequest $request, Permission $permission)
    {
        $request->validate([
            'slug' => 'required|string|unique:permissions,slug,' . $permission->id,
        ]);

        $validated = $request->validated();
        $permission->update($request->only('name', 'slug', 'description', 'model'));

        if ($permission) {
            $roles = $validated['roles'];
            $rolesSync = collect([]);
            if (count($roles) > 0) {
                if (is_array($roles[0])) {
                    foreach ($roles as $key => $role) {
                        $rolesSync->push($role['id']);
                    }
                } else {
                    $rolesSync = $roles;
                }
            }
            $permission->roles()->sync($rolesSync);
        }

        $permission->load([
            'users:name,id,email',
            'roles:id,name',
        ]);

        return response()->json([
            'permission' => $permission,
        ]);
    }

    public function deletePermission(Request $request, Permission $permission)
    {
        $permission->delete();

        return response()->json($permission);
    }
}
