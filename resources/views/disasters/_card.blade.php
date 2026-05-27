@php
$colors = [
    'flood'     => ['bg' => 'blue',   'emoji' => '🌊'],
    'earthquake'=> ['bg' => 'stone',  'emoji' => '🏚️'],
    'cyclone'   => ['bg' => 'indigo', 'emoji' => '🌀'],
    'fire'      => ['bg' => 'red',    'emoji' => '🔥'],
    'landslide' => ['bg' => 'amber',  'emoji' => '⛰️'],
    'pandemic'  => ['bg' => 'teal',   'emoji' => '🦠'],
];
$c = $colors[$disaster->type] ?? ['bg' => 'gray', 'emoji' => '⚠️'];
@endphp

<a href="{{ route('disasters.show', $disaster) }}"
   class="card-lift block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden group">

    {{-- Type color bar --}}
    <div class="h-1.5 bg-gradient-to-r from-{{ $c['bg'] }}-400 to-{{ $c['bg'] }}-600"></div>

    <div class="p-5">
        <div class="flex items-start justify-between mb-3">
            <span class="text-2xl">{{ $c['emoji'] }}</span>
            <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                {{ $disaster->severity === 'critical' ? 'bg-red-100 text-red-700' :
                   ($disaster->severity === 'high'    ? 'bg-orange-100 text-orange-700' :
                   ($disaster->severity === 'medium'  ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700')) }}">
                {{ ucfirst($disaster->severity) }}
            </span>
        </div>

        <h3 class="font-semibold text-gray-900 group-hover:text-orange-600 transition-colors mb-1 line-clamp-1">
            {{ $disaster->name }}
        </h3>
        <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">
            {{ $disaster->description }}
        </p>

        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-50">
            <span class="text-xs text-gray-400 capitalize">{{ $disaster->type }}</span>
            @if($disaster->region)
            <span class="text-xs text-gray-400 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                {{ $disaster->region }}
            </span>
            @endif
            <span class="text-xs text-gray-400 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $disaster->views }}
            </span>
        </div>
    </div>
</a>
