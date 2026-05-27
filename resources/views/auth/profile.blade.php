@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">

    <h1 class="font-display font-bold text-3xl text-gray-900 mb-8">My Profile</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- Profile Card --}}
        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h2 class="font-semibold text-gray-900 text-lg">{{ $user->name }}</h2>
                <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                @if($user->location)
                <p class="text-gray-400 text-xs mt-1 flex items-center justify-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    {{ $user->location }}
                </p>
                @endif
                <span class="inline-block mt-3 text-xs font-semibold px-3 py-1 rounded-full
                    {{ $user->isAdmin() ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ ucfirst($user->role) }}
                </span>

                <div class="grid grid-cols-2 gap-3 mt-6 pt-6 border-t border-gray-50 text-center">
                    <div>
                        <p class="text-2xl font-bold text-orange-500">{{ $user->checklists->count() }}</p>
                        <p class="text-xs text-gray-400">Checklists</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-violet-500">{{ $user->tips->count() }}</p>
                        <p class="text-xs text-gray-400">Tips Shared</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Form --}}
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-5">Edit Profile</h3>
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Location</label>
                        <input type="text" name="location" value="{{ old('location', $user->location) }}"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition"
                               placeholder="City, State">
                    </div>
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
                        Save Changes
                    </button>
                </form>
            </div>

            {{-- Session info (demonstrates sessions) --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Session Information</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Current Locale</span>
                        <span class="font-medium text-gray-800">{{ strtoupper(app()->getLocale()) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Member Since</span>
                        <span class="font-medium text-gray-800">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-500">Session ID (truncated)</span>
                        <span class="font-mono text-xs text-gray-600">{{ substr(session()->getId(), 0, 16) }}…</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
