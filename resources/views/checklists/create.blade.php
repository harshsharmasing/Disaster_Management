@extends('layouts.app')
@section('title', 'Create Checklist')

@section('content')
<div class="max-w-lg mx-auto px-4 sm:px-6 py-10">

    <div class="mb-8">
        <a href="{{ route('checklists.index') }}" class="text-sm text-gray-500 hover:text-orange-500 flex items-center gap-1 mb-4 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            My Checklists
        </a>
        <h1 class="font-display font-bold text-2xl text-gray-900">Create Checklist</h1>
        <p class="text-gray-500 text-sm mt-1">Pick a disaster type to generate a pre-filled checklist.</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <form method="POST" action="{{ route('checklists.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Checklist Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', request('title', '')) }}"
                       class="w-full px-4 py-2.5 border rounded-xl text-sm transition {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100' }}"
                       placeholder="e.g. Home Flood Preparedness">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Disaster Type <span class="text-red-500">*</span></label>
                @php
                $typeInfo = [
                    'flood'     => ['emoji' => '🌊', 'color' => 'blue'],
                    'earthquake'=> ['emoji' => '🏚️', 'color' => 'stone'],
                    'cyclone'   => ['emoji' => '🌀', 'color' => 'indigo'],
                    'fire'      => ['emoji' => '🔥', 'color' => 'red'],
                    'landslide' => ['emoji' => '⛰️', 'color' => 'amber'],
                    'pandemic'  => ['emoji' => '🦠', 'color' => 'teal'],
                ];
                @endphp
                <div class="grid grid-cols-3 gap-2">
                    @foreach($types as $type)
                    @php $info = $typeInfo[$type] ?? ['emoji'=>'⚠️','color'=>'gray']; @endphp
                    <label class="cursor-pointer">
                        <input type="radio" name="disaster_type" value="{{ $type }}"
                               class="sr-only peer"
                               {{ old('disaster_type', request('type')) === $type ? 'checked' : '' }}>
                        <div class="flex flex-col items-center gap-1.5 p-3 rounded-xl border-2 border-gray-100 text-center
                                    peer-checked:border-orange-400 peer-checked:bg-orange-50 hover:border-gray-300 transition-colors">
                            <span class="text-xl">{{ $info['emoji'] }}</span>
                            <span class="text-xs font-semibold text-gray-700 capitalize">{{ $type }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('disaster_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl transition-colors shadow-sm">
                Generate Checklist
            </button>
        </form>
    </div>
</div>
@endsection
