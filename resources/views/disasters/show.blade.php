@extends('layouts.app')
@section('title', $disaster->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('disasters.index') }}" class="hover:text-orange-500 transition-colors">Disaster Library</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 font-medium">{{ $disaster->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Title Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                @php
                $typeColors = [
                    'flood'     => 'from-blue-500 to-blue-700',
                    'earthquake'=> 'from-stone-500 to-stone-700',
                    'cyclone'   => 'from-indigo-500 to-indigo-700',
                    'fire'      => 'from-red-500 to-red-700',
                    'landslide' => 'from-amber-500 to-amber-700',
                    'pandemic'  => 'from-teal-500 to-teal-700',
                ];
                $grad = $typeColors[$disaster->type] ?? 'from-gray-500 to-gray-700';
                @endphp
                <div class="h-2 bg-gradient-to-r {{ $grad }}"></div>
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-3xl">{{ $disaster->typeIcon() }}</span>
                                <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ $disaster->type }}</span>
                            </div>
                            <h1 class="font-display font-bold text-2xl md:text-3xl text-gray-900">{{ $disaster->name }}</h1>
                        </div>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full mt-1
                            {{ $disaster->severity === 'critical' ? 'bg-red-100 text-red-700' :
                               ($disaster->severity === 'high'    ? 'bg-orange-100 text-orange-700' :
                               ($disaster->severity === 'medium'  ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700')) }}">
                            {{ ucfirst($disaster->severity) }} Risk
                        </span>
                    </div>
                    <p class="text-gray-600 leading-relaxed">{{ $disaster->description }}</p>
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-gray-50 text-xs text-gray-400">
                        @if($disaster->region)
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $disaster->region }}
                        </span>
                        @endif
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $disaster->views }} views
                        </span>
                        <span>Added {{ $disaster->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            {{-- What To Do --}}
            <div class="bg-green-50 border border-green-200 rounded-2xl p-6">
                <h2 class="font-semibold text-green-900 text-lg flex items-center gap-2 mb-4">
                    <span class="w-7 h-7 bg-green-500 rounded-lg flex items-center justify-center text-white text-sm">✓</span>
                    What To Do
                </h2>
                <div class="text-green-800 leading-relaxed whitespace-pre-line text-sm">{{ $disaster->what_to_do }}</div>
            </div>

            {{-- What Not To Do --}}
            <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                <h2 class="font-semibold text-red-900 text-lg flex items-center gap-2 mb-4">
                    <span class="w-7 h-7 bg-red-500 rounded-lg flex items-center justify-center text-white text-sm">✕</span>
                    What Not To Do
                </h2>
                <div class="text-red-800 leading-relaxed whitespace-pre-line text-sm">{{ $disaster->what_not_to_do }}</div>
            </div>

        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Checklist CTA --}}
            @auth
            <div class="bg-gradient-to-br from-violet-600 to-purple-700 rounded-2xl p-6 text-white">
                <h3 class="font-semibold mb-2">Make a Checklist</h3>
                <p class="text-white/75 text-sm mb-4">Track your preparedness for {{ $disaster->type }} scenarios.</p>
                <a href="{{ route('checklists.create', ['type' => $disaster->type]) }}"
                   class="block text-center bg-white text-purple-700 font-semibold text-sm py-2 rounded-xl hover:bg-purple-50 transition-colors">
                    Create Checklist
                </a>
            </div>
            @endauth

            {{-- Admin actions --}}
            @auth
            @if(auth()->user()->isAdmin())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-semibold text-gray-700 text-sm mb-3">Admin Actions</h3>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('disasters.edit', $disaster) }}"
                       class="text-center text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 rounded-xl transition-colors">
                        Edit Disaster
                    </a>
                    <form method="POST" action="{{ route('disasters.destroy', $disaster) }}"
                          onsubmit="return confirm('Delete this disaster entry?')">
                        @csrf @method('DELETE')
                        <button class="w-full text-sm bg-red-50 hover:bg-red-100 text-red-600 font-medium py-2 rounded-xl transition-colors">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @endif
            @endauth

            {{-- Related --}}
            @if($related->count())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-semibold text-gray-700 text-sm mb-4">Related Disasters</h3>
                <div class="space-y-3">
                    @foreach($related as $rel)
                    <a href="{{ route('disasters.show', $rel) }}"
                       class="flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 transition-colors group">
                        <span class="text-xl">{{ $rel->typeIcon() }}</span>
                        <div>
                            <p class="text-sm font-medium text-gray-800 group-hover:text-orange-500 transition-colors">{{ $rel->name }}</p>
                            <p class="text-xs text-gray-400">{{ ucfirst($rel->severity) }} risk</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
