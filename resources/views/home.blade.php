@extends('layouts.app')
@section('title', __('home.title'))

@section('content')

{{-- ── Hero ──────────────────────────────────────────────────────────────────── --}}
<section class="hero-gradient text-white relative overflow-hidden">
    {{-- Floating orbs --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/5 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/5 w-96 h-96 bg-orange-400 opacity-10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-24 md:py-32">
        <div class="max-w-2xl">
            {{-- Tag --}}
            <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-sm font-medium mb-6 backdrop-blur-sm">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                {{ __('home.hero_tag') }}
            </div>

            <h1 class="font-display font-extrabold text-4xl md:text-6xl leading-tight mb-6">
                {!! __('home.hero_title') !!}
            </h1>
            <p class="text-lg md:text-xl text-white/75 leading-relaxed mb-8 max-w-lg">
                {{ __('home.hero_subtitle') }}
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('disasters.index') }}"
                   class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-400 text-white font-semibold px-6 py-3 rounded-xl transition-colors shadow-lg shadow-orange-900/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    {{ __('home.explore_cta') }}
                </a>
                <a href="{{ route('contacts.index') }}"
                   class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/30 text-white font-semibold px-6 py-3 rounded-xl transition-colors backdrop-blur-sm">
                    {{ __('home.contacts_cta') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Wave divider --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 60L1440 60L1440 20C1200 60 960 0 720 20C480 40 240 0 0 20V60Z" fill="#F9FAFB"/>
        </svg>
    </div>
</section>

{{-- ── Stats Bar ─────────────────────────────────────────────────────────────── --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 -mt-6 relative z-10">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 grid grid-cols-3 gap-6 text-center">
        @php
            $stats = [
                ['value' => \App\Models\Disaster::count(), 'label' => __('home.stat_disasters'), 'color' => 'orange'],
                ['value' => $contactCount,                  'label' => __('home.stat_contacts'),  'color' => 'blue'],
                ['value' => $tipCount,                       'label' => __('home.stat_tips'),      'color' => 'green'],
            ];
        @endphp
        @foreach($stats as $stat)
        <div>
            <p class="text-3xl font-display font-bold text-{{ $stat['color'] }}-500">{{ $stat['value'] }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ── Featured Disasters ────────────────────────────────────────────────────── --}}
@if($featured->count())
<section class="max-w-6xl mx-auto px-4 sm:px-6 mt-16">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-display font-bold text-2xl text-gray-900">{{ __('home.featured_title') }}</h2>
            <p class="text-gray-500 text-sm mt-1">{{ __('home.featured_subtitle') }}</p>
        </div>
        <a href="{{ route('disasters.index') }}" class="text-orange-500 hover:text-orange-600 text-sm font-medium flex items-center gap-1">
            {{ __('home.see_all') }}
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($featured as $disaster)
        @include('disasters._card', compact('disaster'))
        @endforeach
    </div>
</section>
@endif

{{-- ── How It Works ──────────────────────────────────────────────────────────── --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 mt-20">
    <h2 class="font-display font-bold text-2xl text-gray-900 text-center mb-12">{{ __('home.how_title') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
        $steps = [
            ['icon' => '🔍', 'title' => __('home.step1_title'), 'desc' => __('home.step1_desc'), 'color' => 'orange'],
            ['icon' => '✅', 'title' => __('home.step2_title'), 'desc' => __('home.step2_desc'), 'color' => 'blue'],
            ['icon' => '📞', 'title' => __('home.step3_title'), 'desc' => __('home.step3_desc'), 'color' => 'green'],
            ['icon' => '💬', 'title' => __('home.step4_title'), 'desc' => __('home.step4_desc'), 'color' => 'purple'],
        ];
        @endphp
        @foreach($steps as $i => $step)
        <div class="card-lift bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-center">
            <div class="text-3xl mb-4">{{ $step['icon'] }}</div>
            <div class="w-6 h-6 rounded-full bg-{{ $step['color'] }}-100 text-{{ $step['color'] }}-600 text-xs font-bold flex items-center justify-center mx-auto mb-3">
                {{ $i + 1 }}
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">{{ $step['title'] }}</h3>
            <p class="text-gray-500 text-sm leading-relaxed">{{ $step['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ── CTA ───────────────────────────────────────────────────────────────────── --}}
@guest
<section class="max-w-6xl mx-auto px-4 sm:px-6 mt-16 mb-8">
    <div class="bg-gradient-to-r from-violet-600 to-purple-700 rounded-3xl p-10 text-center text-white shadow-xl">
        <h2 class="font-display font-bold text-2xl md:text-3xl mb-3">{{ __('home.cta_title') }}</h2>
        <p class="text-white/75 mb-6 max-w-md mx-auto">{{ __('home.cta_subtitle') }}</p>
        <a href="{{ route('register') }}" class="inline-block bg-white text-purple-700 font-bold px-8 py-3 rounded-xl hover:bg-purple-50 transition-colors shadow-lg">
            {{ __('home.cta_button') }}
        </a>
    </div>
</section>
@endguest

@endsection
