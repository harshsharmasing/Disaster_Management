@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h1 class="font-display font-bold text-2xl text-gray-900">Create account</h1>
            <p class="text-gray-500 text-sm mt-1">Join SafeGuard — it's free</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" autofocus
                           class="w-full px-4 py-2.5 border rounded-xl text-sm transition
                                  {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100' }}"
                           placeholder="Priya Sharma">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-2.5 border rounded-xl text-sm transition
                                  {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100' }}"
                           placeholder="you@example.com">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Location <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="text" name="location" value="{{ old('location') }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition"
                           placeholder="Mumbai, Maharashtra">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password"
                           class="w-full px-4 py-2.5 border rounded-xl text-sm transition
                                  {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100' }}"
                           placeholder="At least 8 characters">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition"
                           placeholder="Repeat password">
                </div>

                <button type="submit"
                        class="w-full bg-violet-600 hover:bg-violet-700 text-white font-semibold py-3 rounded-xl transition-colors shadow-sm">
                    Create Account
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-500 mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="text-orange-500 font-semibold hover:text-orange-600 transition-colors">Sign in</a>
        </p>
    </div>
</div>
@endsection
