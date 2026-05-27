@extends('layouts.app')
@section('title', 'My Checklists')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-display font-bold text-3xl text-gray-900 mb-1">My Checklists</h1>
            <p class="text-gray-500">Track your disaster preparedness progress.</p>
        </div>
        <a href="{{ route('checklists.create') }}"
           class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Checklist
        </a>
    </div>

    @if($checklists->isEmpty())
    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
        <p class="text-6xl mb-4">📋</p>
        <h3 class="font-semibold text-gray-700 mb-2">No checklists yet</h3>
        <p class="text-gray-500 text-sm mb-6">Create your first disaster preparedness checklist.</p>
        <a href="{{ route('checklists.create') }}" class="inline-block bg-orange-500 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-orange-600 transition-colors">
            Create First Checklist
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach($checklists as $list)
        @php
        $pct = $list->completionPercent();
        $typeEmoji = ['flood'=>'🌊','earthquake'=>'🏚️','cyclone'=>'🌀','fire'=>'🔥','landslide'=>'⛰️','pandemic'=>'🦠'];
        $emoji = $typeEmoji[$list->disaster_type] ?? '⚠️';
        @endphp
        <div class="card-lift bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">{{ $emoji }}</span>
                    <div>
                        <h3 class="font-semibold text-gray-900 leading-tight">{{ $list->title }}</h3>
                        <p class="text-xs text-gray-400 capitalize mt-0.5">{{ $list->disaster_type }}</p>
                    </div>
                </div>
                <span class="text-lg font-bold {{ $pct >= 80 ? 'text-green-500' : ($pct >= 40 ? 'text-orange-500' : 'text-red-500') }}">
                    {{ $pct }}%
                </span>
            </div>

            {{-- Progress bar --}}
            <div class="w-full h-2 bg-gray-100 rounded-full mb-4 overflow-hidden">
                <div class="h-2 rounded-full transition-all duration-500
                    {{ $pct >= 80 ? 'bg-green-500' : ($pct >= 40 ? 'bg-orange-500' : 'bg-red-500') }}"
                     style="width: {{ $pct }}%">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <span class="text-xs text-gray-400">{{ count(array_filter($list->items ?? [], fn($i) => $i['checked'])) }} / {{ count($list->items ?? []) }} done</span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('checklists.show', $list) }}"
                       class="text-sm font-medium text-orange-500 hover:text-orange-600 transition-colors">
                        Open →
                    </a>
                    <form method="POST" action="{{ route('checklists.destroy', $list) }}"
                          onsubmit="return confirm('Delete this checklist?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-gray-400 hover:text-red-500 transition-colors">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
