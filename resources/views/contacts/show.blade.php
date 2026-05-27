@extends('layouts.app')
@section('title', $contact->name)

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    <a href="{{ route('contacts.index') }}" class="text-sm text-gray-500 hover:text-orange-500 flex items-center gap-1 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Emergency Contacts
    </a>

    @php
    $typeInfo = [
        'hospital' => ['emoji' => '🏥', 'color' => 'red'],
        'police'   => ['emoji' => '🚔', 'color' => 'blue'],
        'fire'     => ['emoji' => '🚒', 'color' => 'orange'],
        'ngo'      => ['emoji' => '🤝', 'color' => 'green'],
        'helpline' => ['emoji' => '📞', 'color' => 'purple'],
    ];
    $info = $typeInfo[$contact->type] ?? ['emoji' => '📋', 'color' => 'gray'];
    @endphp

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="h-2 bg-{{ $info['color'] }}-500"></div>
        <div class="p-8">
            <div class="flex items-center gap-4 mb-6">
                <span class="text-4xl">{{ $info['emoji'] }}</span>
                <div>
                    <h1 class="font-display font-bold text-2xl text-gray-900">{{ $contact->name }}</h1>
                    <span class="text-sm font-semibold capitalize text-{{ $info['color'] }}-600">{{ $contact->type }}</span>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Phone</p>
                        <a href="tel:{{ $contact->phone }}" class="text-lg font-bold text-{{ $info['color'] }}-600 hover:underline">
                            {{ $contact->phone }}
                        </a>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Location</p>
                        <p class="font-semibold text-gray-800">{{ $contact->city }}, {{ $contact->state }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <span class="w-2.5 h-2.5 rounded-full {{ $contact->is_available ? 'bg-green-500' : 'bg-red-400' }}"></span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Status</p>
                        <p class="font-semibold {{ $contact->is_available ? 'text-green-700' : 'text-red-600' }}">
                            {{ $contact->is_available ? 'Available 24/7' : 'Currently unavailable' }}
                        </p>
                    </div>
                </div>
            </div>

            <a href="tel:{{ $contact->phone }}"
               class="mt-6 flex items-center justify-center gap-2 w-full bg-{{ $info['color'] }}-500 hover:bg-{{ $info['color'] }}-600 text-white font-bold py-3.5 rounded-xl transition-colors shadow-sm text-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Call Now
            </a>
        </div>
    </div>
</div>
@endsection
