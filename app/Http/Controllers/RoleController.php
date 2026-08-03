<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Permission;

class RoleController extends Controller implements HasMiddleware
{
    public function index(): View
    {
        $roles = Role::latest()->paginate(10);

        return view('roles.index', compact('roles'));
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        Role::create($request->validated());

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function edit(Role $role): View
    {
        $roles = Role::latest()->paginate(10);

        return view('roles.index', [
            'roles' => $roles,
            'editRole' => $role,
        ]);
    }

    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        // منع حذف Super Admin
        if ($role->name === 'Super Admin') {

            return redirect()
                ->route('roles.index')
                ->with('error', 'Super Admin role cannot be deleted.');

        }

        // منع حذف Role مستخدم
        if ($role->users()->exists()) {

            return redirect()
                ->route('roles.index')
                ->with('error', 'This role is assigned to users and cannot be deleted.');

        }

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    public function permissions(Role $role): View
    {
        $permissions = Permission::all();

        return view('roles.permissions', compact(
            'role',
            'permissions'
        ));
    }

    public function updatePermissions(Request $request, Role $role): RedirectResponse
    {
        $role->permissions()->sync(
            $request->permissions ?? []
        );


        return redirect()
            ->route('roles.index')
            ->with('success', 'Permissions updated successfully.');
    }

    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Roles', only: ['index']),

            new Middleware('permission:Add Role', only: ['store']),

            new Middleware('permission:Edit Role', only: ['edit', 'update']),

            new Middleware('permission:Delete Role', only: ['destroy']),

            new Middleware('permission:Assign Permissions', only: [
                'permissions',
                'updatePermissions',
            ]),

        ];
    }
    
}
