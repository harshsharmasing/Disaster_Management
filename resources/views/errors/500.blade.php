@extends('layouts.app')
@section('title', '500 — Server Error')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="text-center">
        <p class="text-8xl mb-6">⚡</p>
        <h1 class="font-display font-bold text-5xl text-gray-900 mb-3">500</h1>
        <p class="text-xl text-gray-500 mb-2">Something went wrong</p>
        <p class="text-gray-400 text-sm mb-8">An internal server error occurred. Please try again later.</p>
        <a href="{{ route('home') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors shadow-sm">
            Go Home
        </a>
    </div>
</div>
@endsection
