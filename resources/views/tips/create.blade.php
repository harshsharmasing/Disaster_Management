@extends('layouts.app')
@section('title', 'Share a Tip')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    <a href="{{ route('tips.index') }}" class="text-sm text-gray-500 hover:text-orange-500 flex items-center gap-1 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Community Tips
    </a>

    <div class="mb-8">
        <h1 class="font-display font-bold text-2xl text-gray-900 mb-1">Share Your Experience</h1>
        <p class="text-gray-500 text-sm">Your tip helps others prepare. It will appear after quick review.</p>
    </div>

    {{-- Validation Summary --}}
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-6">
        <p class="text-red-700 font-semibold text-sm mb-2">Please fix the following:</p>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li class="text-red-600 text-sm">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <form method="POST" action="{{ route('tips.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Tip Title <span class="text-red-500">*</span>
                </label>
                {{-- old() demonstrates repopulating forms after validation fail --}}
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full px-4 py-2.5 border rounded-xl text-sm transition
                              {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100' }}"
                       placeholder="e.g. How I protected my house from flooding">
                @error('title')
                <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/></svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Disaster Type <span class="text-red-500">*</span></label>
                    <select name="disaster_type"
                            class="w-full px-4 py-2.5 border rounded-xl text-sm bg-white transition
                                   {{ $errors->has('disaster_type') ? 'border-red-400' : 'border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100' }}">
                        <option value="">Select…</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ old('disaster_type') === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                    @error('disaster_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Region <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="text" name="region" value="{{ old('region') }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition"
                           placeholder="e.g. Mumbai">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Your Tip <span class="text-red-500">*</span>
                    <span class="text-gray-400 font-normal">(at least 30 characters)</span>
                </label>
                <textarea name="body" rows="6"
                          class="w-full px-4 py-2.5 border rounded-xl text-sm transition resize-none
                                 {{ $errors->has('body') ? 'border-red-400 bg-red-50' : 'border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-100' }}"
                          placeholder="Share what you learned — what worked, what didn't, what you wish you'd known beforehand…"
                          id="body-field">{{ old('body') }}</textarea>
                <div class="flex items-center justify-between mt-1">
                    @error('body')
                    <p class="text-red-500 text-xs flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/></svg>
                        {{ $message }}
                    </p>
                    @else <span></span>
                    @enderror
                    <span id="char-count" class="text-xs text-gray-400 ml-auto">0 / 3000</span>
                </div>
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800">
                <strong>Note:</strong> Your tip will be reviewed before publishing. Tips that are clear, specific, and helpful are approved fastest.
            </div>

            <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl transition-colors shadow-sm">
                Submit Tip for Review
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const body  = document.getElementById('body-field');
    const count = document.getElementById('char-count');
    body.addEventListener('input', () => {
        const len = body.value.length;
        count.textContent = `${len} / 3000`;
        count.className = len >= 30 ? 'text-xs text-green-600 ml-auto' : 'text-xs text-gray-400 ml-auto';
    });
    // Trigger on load to populate count if old() filled
    body.dispatchEvent(new Event('input'));
</script>
@endpush
