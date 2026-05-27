@extends('layouts.app')
@section('title', '404 — Page Not Found')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="text-center">
        <p class="text-8xl mb-6">🗺️</p>
        <h1 class="font-display font-bold text-5xl text-gray-900 mb-3">404</h1>
        <p class="text-xl text-gray-500 mb-2">Page not found</p>
        <p class="text-gray-400 text-sm mb-8">The page you're looking for doesn't exist or has been moved.</p>
        <div class="flex items-center justify-center gap-3">
            <a href="{{ route('home') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors shadow-sm">
                Go Home
            </a>
            <a href="{{ route('disasters.index') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold px-6 py-2.5 rounded-xl transition-colors">
                Disaster Library
            </a>
        </div>
    </div>
</div>
@endsection
