@extends('layouts.app')
@section('title', $tip->title)

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    <a href="{{ route('tips.index') }}" class="text-sm text-gray-500 hover:text-orange-500 flex items-center gap-1 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Community Tips
    </a>

    <article class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <div class="flex items-center gap-2 mb-4 flex-wrap">
            <span class="text-xs font-semibold bg-orange-50 text-orange-700 border border-orange-100 px-2.5 py-0.5 rounded-full capitalize">
                {{ $tip->disaster_type }}
            </span>
            @if($tip->region)
            <span class="text-xs text-gray-400 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                {{ $tip->region }}
            </span>
            @endif
        </div>

        <h1 class="font-display font-bold text-2xl text-gray-900 mb-6 leading-snug">{{ $tip->title }}</h1>

        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $tip->body }}</p>

        <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-50 text-sm text-gray-500">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-400 to-purple-600 flex items-center justify-center text-white font-bold text-xs">
                {{ strtoupper(substr($tip->user->name, 0, 1)) }}
            </div>
            <div>
                <span class="font-medium text-gray-800">{{ $tip->user->name }}</span>
                <span class="mx-1">·</span>
                <span>{{ $tip->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </article>

</div>
@endsection
