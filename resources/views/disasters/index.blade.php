@extends('layouts.app')
@section('title', 'Disaster Library')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="font-display font-bold text-3xl text-gray-900 mb-2">Disaster Library</h1>
        <p class="text-gray-500">Learn about different disasters — causes, warnings, and what to do.</p>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('disasters.index') }}"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-8 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-48">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Search</label>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search disasters..."
                       class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition">
            </div>
        </div>
        <div class="min-w-36">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Type</label>
            <select name="type" class="w-full py-2 px-3 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition bg-white">
                <option value="">All types</option>
                @foreach($types as $type)
                    <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2 rounded-xl text-sm transition-colors shadow-sm">
            Filter
        </button>
        @if(request()->hasAny(['search','type']))
            <a href="{{ route('disasters.index') }}" class="text-sm text-gray-500 hover:text-gray-700 py-2 transition-colors">
                Clear
            </a>
        @endif
    </form>

    {{-- Admin add button --}}
    @auth
        @if(auth()->user()->isAdmin())
        <div class="mb-6">
            <a href="{{ route('disasters.create') }}"
               class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Disaster
            </a>
        </div>
        @endif
    @endauth

    {{-- Results --}}
    @if($disasters->isEmpty())
    <div class="text-center py-20">
        <p class="text-5xl mb-4">🔍</p>
        <h3 class="font-semibold text-gray-700 mb-2">No results found</h3>
        <p class="text-gray-500 text-sm">Try a different search term or filter.</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($disasters as $disaster)
            @include('disasters._card', compact('disaster'))
        @endforeach
    </div>

    <div class="mt-8">
        {{ $disasters->links() }}
    </div>
    @endif

</div>
@endsection
