@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-red-600 shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
            <h1 class="font-display font-bold text-2xl text-gray-900">Welcome back</h1>
            <p class="text-gray-500 text-sm mt-1">Sign in to your SafeGuard account</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" autofocus autocomplete="email"
                           class="w-full px-4 py-2.5 border rounded-xl text-sm transition
                                  {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100' }}"
                           placeholder="you@example.com">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-sm font-semibold text-gray-700">Password</label>
                    </div>
                    <input type="password" name="password" autocomplete="current-password"
                           class="w-full px-4 py-2.5 border rounded-xl text-sm transition
                                  {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100' }}"
                           placeholder="••••••••">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                           class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-400">
                    <label for="remember" class="text-sm text-gray-600">Remember me for 30 days</label>
                </div>

                <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl transition-colors shadow-sm">
                    Sign In
                </button>
            </form>

            {{-- Demo credentials --}}
            <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <p class="text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wide">Demo Credentials</p>
                <div class="space-y-1 text-xs font-mono">
                    <div class="flex justify-between"><span class="text-gray-500">Admin:</span><span class="text-gray-700">admin@example.com / password</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">User:</span><span class="text-gray-700">user@example.com / password</span></div>
                </div>
            </div>
        </div>

        <p class="text-center text-sm text-gray-500 mt-6">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-orange-500 font-semibold hover:text-orange-600 transition-colors">
                Create one free
            </a>
        </p>
    </div>
</div>
@endsection
