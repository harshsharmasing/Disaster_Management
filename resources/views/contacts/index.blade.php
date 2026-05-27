@extends('layouts.app')
@section('title', 'Emergency Contacts')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="font-display font-bold text-3xl text-gray-900 mb-2">Emergency Contacts</h1>
        <p class="text-gray-500">Find hospitals, police stations, fire brigades, NGOs and helplines near you.</p>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('contacts.index') }}"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-8 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-44">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">City</label>
            <select name="city" class="w-full py-2 px-3 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition bg-white">
                <option value="">All cities</option>
                @foreach($cities as $city)
                    <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-44">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Type</label>
            <select name="type" class="w-full py-2 px-3 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition bg-white">
                <option value="">All types</option>
                @foreach($types as $type)
                    <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2 rounded-xl text-sm transition-colors shadow-sm">
            Search
        </button>
        @if(request()->hasAny(['city','type']))
            <a href="{{ route('contacts.index') }}" class="text-sm text-gray-500 hover:text-gray-700 py-2 transition-colors">Clear</a>
        @endif

        {{-- API link --}}
        <div class="ml-auto">
            <a href="/api/contacts" target="_blank"
               class="inline-flex items-center gap-1.5 text-xs font-mono bg-gray-900 text-green-400 px-3 py-2 rounded-xl hover:bg-gray-800 transition-colors">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                GET /api/contacts
            </a>
        </div>
    </form>

    {{-- Type color legend --}}
    <div class="flex flex-wrap gap-2 mb-6">
        @php
        $typeInfo = [
            'hospital' => ['color' => 'red',    'icon' => '🏥'],
            'police'   => ['color' => 'blue',   'icon' => '🚔'],
            'fire'     => ['color' => 'orange', 'icon' => '🚒'],
            'ngo'      => ['color' => 'green',  'icon' => '🤝'],
            'helpline' => ['color' => 'purple', 'icon' => '📞'],
        ];
        @endphp
        @foreach($typeInfo as $t => $info)
        <span class="inline-flex items-center gap-1 text-xs font-medium bg-{{ $info['color'] }}-50 text-{{ $info['color'] }}-700 border border-{{ $info['color'] }}-200 px-2.5 py-1 rounded-full">
            {{ $info['icon'] }} {{ ucfirst($t) }}
        </span>
        @endforeach
    </div>

    {{-- Contacts Grid --}}
    @if($contacts->isEmpty())
    <div class="text-center py-20">
        <p class="text-5xl mb-4">📡</p>
        <h3 class="font-semibold text-gray-700 mb-2">No contacts found</h3>
        <p class="text-gray-500 text-sm">Try a different city or type filter.</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($contacts as $contact)
        @php
        $tInfo = $typeInfo[$contact->type] ?? ['color' => 'gray', 'icon' => '📋'];
        @endphp
        <div class="card-lift bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-start justify-between mb-3">
                <span class="text-2xl">{{ $tInfo['icon'] }}</span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-{{ $tInfo['color'] }}-50 text-{{ $tInfo['color'] }}-700 border border-{{ $tInfo['color'] }}-100">
                    {{ ucfirst($contact->type) }}
                </span>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">{{ $contact->name }}</h3>
            <p class="text-xs text-gray-400 mb-3">{{ $contact->city }}, {{ $contact->state }}</p>
            <a href="tel:{{ $contact->phone }}"
               class="flex items-center gap-2 text-sm font-semibold text-{{ $tInfo['color'] }}-600 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                {{ $contact->phone }}
            </a>
            <div class="mt-3 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full {{ $contact->is_available ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                <span class="text-xs text-gray-400">{{ $contact->is_available ? 'Available' : 'Unavailable' }}</span>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-8">{{ $contacts->links() }}</div>
    @endif
</div>
@endsection
