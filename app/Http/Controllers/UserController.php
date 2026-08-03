<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller implements HasMiddleware
{

    public function index(): View
    {
        $users = User::with('role')->latest()->paginate(10);
        $roles = Role::all();

        return view('users.index', compact(
            'users',
            'roles'
        ));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => $request->status,

        ]);

        return redirect()->route('users.index')->with('success','User created successfully.');
    }

    public function edit(User $user): View
    {
        $users = User::with('role')->latest()->paginate(10);
        $roles = Role::all();

        return view('users.index',[
            'users' => $users,
            'roles' => $roles,
            'editUser' => $user,
        ]);

    }

    public function update(UpdateUserRequest $request,User $user): RedirectResponse {

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
            'status' => $request->status,

        ];

        if($request->filled('password')){
            $data['password'] =
                Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success','User updated successfully.');

    }

    public function destroy(User $user): RedirectResponse
    {
        if($user->id === auth()->id()){

            return redirect()->route('users.index')
                ->with(
                    'error',
                    'You cannot delete your own account.'
                );
        }

        $user->delete();

        return redirect()->route('users.index')->with(
                'success',
                'User deleted successfully.'
            );
    }

    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Users', only: ['index']),

            new Middleware('permission:Add User', only: ['store']),

            new Middleware('permission:Edit User', only: ['edit', 'update']),

            new Middleware('permission:Delete User', only: ['destroy']),

        ];
    }

}
