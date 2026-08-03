<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PermissionController extends Controller implements HasMiddleware
{

    public function index(): View
    {
        $permissions = Permission::latest()
            ->paginate(10);

        return view(
            'permissions.index',
            compact('permissions')
        );
    }

    public function store(
        StorePermissionRequest $request
    ): RedirectResponse {

        Permission::create(
            $request->validated()
        );

        return redirect()
            ->route('permissions.index')
            ->with(
                'success',
                'Permission created successfully.'
            );

    }

    public function edit(
        Permission $permission
    ): View {

        $permissions = Permission::latest()
            ->paginate(10);

        return view(
    'permissions.index',
    [
        'permissions' => $permissions,
        'editPermission' => $permission,
    ]
);

    }

    public function update(
        UpdatePermissionRequest $request,
        Permission $permission
    ): RedirectResponse {

        $permission->update(
            $request->validated()
        );

        return redirect()
            ->route('permissions.index')
            ->with(
                'success',
                'Permission updated successfully.'
            );

    }

    public function destroy(
        Permission $permission
    ): RedirectResponse {

        $permission->delete();

        return redirect()
            ->route('permissions.index')
            ->with(
                'success',
                'Permission deleted successfully.'
            );

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
