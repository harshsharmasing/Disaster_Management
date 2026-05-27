@extends('layouts.app')
@section('title', 'Add Disaster')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    <div class="mb-8">
        <a href="{{ route('disasters.index') }}" class="text-sm text-gray-500 hover:text-orange-500 transition-colors flex items-center gap-1 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Library
        </a>
        <h1 class="font-display font-bold text-2xl text-gray-900">Add New Disaster</h1>
        <p class="text-gray-500 text-sm mt-1">Fill in the details to add a new entry to the disaster library.</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <form method="POST" action="{{ route('disasters.store') }}" class="space-y-6">
            @csrf

            @include('disasters._form', ['types' => $types, 'severities' => $severities])

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors shadow-sm">
                    Publish Disaster
                </button>
                <a href="{{ route('disasters.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors px-4 py-2.5">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
