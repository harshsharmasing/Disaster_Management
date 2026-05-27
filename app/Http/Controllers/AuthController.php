<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // GET /login
    public function showLogin()
    {
        return view('auth.login');
    }

    // POST /login
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => __('auth.failed')]);
        }

        $request->session()->regenerate();

        // Store preferred locale in cookie (demonstrates cookie attach)
        $response = redirect()->intended(route('home'))
            ->with('success', 'Welcome back, ' . Auth::user()->name . '!');

        return $response->withCookie(
            cookie('user_locale', session('locale', 'en'), 60 * 24 * 30)
        );
    }

    // GET /register
    public function showRegister()
    {
        return view('auth.register');
    }

    // POST /register
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'location' => $request->location,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', 'Account created! Welcome to SafeGuard.');
    }

    // POST /logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Forget the locale cookie on logout
        return redirect()->route('login')
            ->with('success', 'You have been logged out safely.')
            ->withCookie(Cookie::forget('user_locale'));
    }

    // GET /profile
    public function profile()
    {
        $user = auth()->user()->load('checklists', 'tips');
        return view('auth.profile', compact('user'));
    }

    // PUT /profile
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:100'],
        ]);

        auth()->user()->update($request->only('name', 'location'));

        return redirect()->route('profile')
            ->with('success', 'Profile updated.');
    }
}
