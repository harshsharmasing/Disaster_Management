@extends('layouts.app')
@section('title', 'Community Tips')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-display font-bold text-3xl text-gray-900 mb-1">Community Tips</h1>
            <p class="text-gray-500">Real advice from people who've experienced disasters.</p>
        </div>
        @auth
        <a href="{{ route('tips.create') }}"
           class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Share a Tip
        </a>
        @endauth
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('tips.index') }}" class="mb-8 flex gap-2 flex-wrap">
        <button type="submit" name="type" value=""
                class="px-3 py-1.5 rounded-full text-sm font-medium transition-colors
                       {{ !request('type') ? 'bg-orange-500 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:border-orange-400' }}">
            All
        </button>
        @foreach($types as $type)
        <button type="submit" name="type" value="{{ $type }}"
                class="px-3 py-1.5 rounded-full text-sm font-medium capitalize transition-colors
                       {{ request('type') === $type ? 'bg-orange-500 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:border-orange-400' }}">
            {{ $type }}
        </button>
        @endforeach
    </form>

    {{-- Tips List --}}
    @if($tips->isEmpty())
    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
        <p class="text-5xl mb-4">💬</p>
        <h3 class="font-semibold text-gray-700 mb-2">No tips yet</h3>
        <p class="text-gray-500 text-sm mb-6">Be the first to share your experience.</p>
        @auth
        <a href="{{ route('tips.create') }}" class="inline-block bg-orange-500 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-orange-600 transition-colors">
            Share First Tip
        </a>
        @endauth
    </div>
    @else
    <div class="space-y-4">
        @foreach($tips as $tip)
        <article class="card-lift bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                        <span class="text-xs font-semibold bg-orange-50 text-orange-700 border border-orange-100 px-2.5 py-0.5 rounded-full capitalize">
                            {{ $tip->disaster_type }}
                        </span>
                        @if($tip->region)
                        <span class="text-xs text-gray-400 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $tip->region }}
                        </span>
                        @endif
                    </div>
                    <h2 class="font-semibold text-gray-900 text-lg leading-snug mb-2">{{ $tip->title }}</h2>
                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">{{ $tip->body }}</p>
                    <div class="flex items-center gap-3 mt-4 text-xs text-gray-400">
                        <div class="flex items-center gap-1.5">
                            <div class="w-5 h-5 rounded-full bg-gradient-to-br from-violet-400 to-purple-600 flex items-center justify-center text-white font-bold" style="font-size:9px">
                                {{ strtoupper(substr($tip->user->name, 0, 1)) }}
                            </div>
                            <span>{{ $tip->user->name }}</span>
                        </div>
                        <span>·</span>
                        <span>{{ $tip->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-2 flex-shrink-0">
                    @auth
                        @if(auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('tips.approve', $tip) }}">
                            @csrf @method('PATCH')
                            <button class="text-xs bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-lg hover:bg-green-100 transition-colors">
                                Approve
                            </button>
                        </form>
                        @endif
                        @if(auth()->id() === $tip->user_id || auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('tips.destroy', $tip) }}"
                              onsubmit="return confirm('Delete this tip?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-gray-400 hover:text-red-500 transition-colors">Delete</button>
                        </form>
                        @endif
                    @endauth
                </div>
            </div>
        </article>
        @endforeach
    </div>
    <div class="mt-8">{{ $tips->links() }}</div>
    @endif
</div>
@endsection
