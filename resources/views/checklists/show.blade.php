@extends('layouts.app')
@section('title', $checklist->title)

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    <a href="{{ route('checklists.index') }}" class="text-sm text-gray-500 hover:text-orange-500 flex items-center gap-1 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        My Checklists
    </a>

    {{-- Header Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h1 class="font-display font-bold text-xl text-gray-900 mb-1">{{ $checklist->title }}</h1>
                <p class="text-sm text-gray-400 capitalize">{{ $checklist->disaster_type }} preparedness</p>
            </div>
            <span id="pct-badge"
                  class="text-xl font-bold {{ $checklist->completionPercent() >= 80 ? 'text-green-500' : ($checklist->completionPercent() >= 40 ? 'text-orange-500' : 'text-red-500') }}">
                {{ $checklist->completionPercent() }}%
            </span>
        </div>

        {{-- Progress bar --}}
        <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
            <div id="progress-bar"
                 class="h-3 rounded-full transition-all duration-500
                    {{ $checklist->completionPercent() >= 80 ? 'bg-green-500' : ($checklist->completionPercent() >= 40 ? 'bg-orange-500' : 'bg-red-500') }}"
                 style="width: {{ $checklist->completionPercent() }}%">
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-2">
            <span id="done-count">{{ count(array_filter($checklist->items, fn($i) => $i['checked'])) }}</span>
            of {{ count($checklist->items) }} items completed
        </p>
    </div>

    {{-- Checklist Items --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <ul class="divide-y divide-gray-50" id="checklist-items">
            @foreach($checklist->items as $index => $item)
            <li class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50/50 transition-colors {{ $item['checked'] ? 'opacity-70' : '' }}"
                id="item-{{ $index }}">
                <button onclick="toggleItem({{ $index }}, this)"
                        class="flex-shrink-0 w-6 h-6 rounded-full border-2 transition-all
                               {{ $item['checked']
                                   ? 'bg-green-500 border-green-500 flex items-center justify-center'
                                   : 'border-gray-300 hover:border-orange-400' }}"
                        data-checked="{{ $item['checked'] ? '1' : '0' }}">
                    @if($item['checked'])
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                    @endif
                </button>
                <span class="text-sm text-gray-700 {{ $item['checked'] ? 'line-through text-gray-400' : '' }}"
                      id="label-{{ $index }}">
                    {{ $item['label'] }}
                </span>
            </li>
            @endforeach
        </ul>
    </div>

    {{-- Completion message --}}
    @if($checklist->completionPercent() === 100)
    <div class="bg-green-50 border border-green-200 rounded-2xl p-5 text-center text-green-800 font-semibold">
        🎉 You're fully prepared! Well done.
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
const totalItems  = {{ count($checklist->items) }};
const toggleUrl   = (index) => `/checklists/{{ $checklist->id }}/toggle/${index}`;
const csrfToken   = document.querySelector('meta[name="csrf-token"]').content;

async function toggleItem(index, btn) {
    const res  = await fetch(toggleUrl(index), {
        method: 'PATCH',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    });
    const data = await res.json();

    const row   = document.getElementById(`item-${index}`);
    const label = document.getElementById(`label-${index}`);

    if (data.checked) {
        btn.className = 'flex-shrink-0 w-6 h-6 rounded-full border-2 bg-green-500 border-green-500 flex items-center justify-center transition-all';
        btn.innerHTML = `<svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>`;
        label.classList.add('line-through', 'text-gray-400');
        row.classList.add('opacity-70');
    } else {
        btn.className = 'flex-shrink-0 w-6 h-6 rounded-full border-2 border-gray-300 hover:border-orange-400 transition-all';
        btn.innerHTML = '';
        label.classList.remove('line-through', 'text-gray-400');
        row.classList.remove('opacity-70');
    }

    const pct  = data.completion;
    const bar  = document.getElementById('progress-bar');
    const badge = document.getElementById('pct-badge');
    const done = document.getElementById('done-count');

    bar.style.width = pct + '%';
    badge.textContent = pct + '%';

    // Recolor based on pct
    const colorClass = pct >= 80 ? 'bg-green-500' : pct >= 40 ? 'bg-orange-500' : 'bg-red-500';
    bar.className = bar.className.replace(/bg-\w+-500/, colorClass);
    badge.className = badge.className.replace(/text-\w+-500/, colorClass.replace('bg-', 'text-'));

    // Count done
    const checkedCount = document.querySelectorAll('[data-checked="1"]').length;
    // Update done count from server response indirectly
    const rawDone = Math.round((pct / 100) * totalItems);
    done.textContent = rawDone;
}
</script>
@endpush
