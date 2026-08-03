<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $remember = $request->boolean('remember');

        if (! Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'status' => true,
        ], $remember)) {

            return back()
                ->withErrors([
                    'email' => 'The provided credentials are incorrect.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        if (auth()->user()->hasPermission('View Dashboard')) {

            return redirect()->intended(route('dashboard'));
        }

        return redirect()->route('store.home');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
            $data = $request->validated();

            User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => 3,
            'status' => true,
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Account created successfully. Please login.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
