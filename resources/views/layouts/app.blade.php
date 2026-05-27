<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SafeGuard') — SafeGuard</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['Inter', 'ui-sans-serif', 'system-ui'],
              display: ['Syne', 'ui-sans-serif'],
            },
            colors: {
              brand: {
                50:  '#fff7ed',
                100: '#ffedd5',
                400: '#fb923c',
                500: '#f97316',
                600: '#ea580c',
                700: '#c2410c',
                900: '#431407',
              },
            },
          },
        },
      }
    </script>

    <style>
      /* Smooth scrolling & antialiasing */
      html { scroll-behavior: smooth; }
      body { -webkit-font-smoothing: antialiased; }

      /* Animated gradient hero */
      .hero-gradient {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 25%, #4c1d95 50%, #7c2d12 75%, #1e1b4b 100%);
        background-size: 400% 400%;
        animation: gradientShift 12s ease infinite;
      }
      @keyframes gradientShift {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
      }

      /* Card hover lift */
      .card-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
      .card-lift:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }

      /* Severity badges */
      .badge-critical { @apply bg-red-100 text-red-800 border border-red-200; }
      .badge-high     { @apply bg-orange-100 text-orange-800 border border-orange-200; }
      .badge-medium   { @apply bg-yellow-100 text-yellow-800 border border-yellow-200; }
      .badge-low      { @apply bg-green-100 text-green-800 border border-green-200; }

      /* Nav glass effect */
      .nav-glass {
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
      }

      /* Custom scrollbar */
      ::-webkit-scrollbar { width: 6px; }
      ::-webkit-scrollbar-track { background: #f1f1f1; }
      ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
      ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

      /* Page transitions */
      .page-enter { animation: fadeSlideUp 0.3s ease; }
      @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
      }

      /* Focus ring */
      input:focus, select:focus, textarea:focus {
        outline: none;
        ring: 2px;
      }
    </style>

    @stack('head')
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">

{{-- ── Emergency Banner (flash-based) ──────────────────────────────────────── --}}
@if(session('emergency'))
<div class="bg-red-600 text-white text-center py-2 px-4 text-sm font-medium">
    ⚠️ {{ session('emergency') }}
</div>
@endif

{{-- ── Navigation ───────────────────────────────────────────────────────────── --}}
<nav class="nav-glass sticky top-0 z-50 border-b border-gray-200/60 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <span class="font-display font-bold text-lg text-gray-900">Disaster<span class="text-orange-500">Ready</span></span>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-1">
                @php
                    $navItems = [
                        ['route' => 'home',            'label' => __('nav.home')],
                        ['route' => 'disasters.index', 'label' => __('nav.disasters')],
                        ['route' => 'contacts.index',  'label' => __('nav.contacts')],
                        ['route' => 'tips.index',      'label' => __('nav.tips')],
                    ];
                @endphp
                @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors
                              {{ request()->routeIs(rtrim($item['route'], '.index') . '*')
                                 ? 'bg-orange-50 text-orange-600'
                                 : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-3">



                @auth
                    {{-- User menu --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('profile') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Str::limit(auth()->user()->name, 12) }}</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 text-sm text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                {{ __('nav.logout') }}
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                        {{ __('nav.login') }}
                    </a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold bg-orange-500 hover:bg-orange-600 text-white px-4 py-1.5 rounded-lg transition-colors shadow-sm">
                        {{ __('nav.register') }}
                    </a>
                @endauth
            </div>

        </div>
    </div>
</nav>

{{-- ── Flash Messages ────────────────────────────────────────────────────────── --}}
@if(session('success') || session('error'))
<div class="max-w-6xl mx-auto px-4 sm:px-6 mt-4">
    @if(session('success'))
    <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif
</div>
@endif

{{-- ── Main Content ──────────────────────────────────────────────────────────── --}}
<main class="flex-1 page-enter">
    @yield('content')
</main>

{{-- ── Footer ───────────────────────────────────────────────────────────────── --}}
<footer class="bg-gray-900 text-gray-400 mt-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <span class="font-display font-bold text-white">SafeGuard</span>
                </div>
                <p class="text-sm leading-relaxed">Helping communities prepare for, respond to, and recover from disasters.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm mb-3">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('disasters.index') }}" class="hover:text-white transition-colors">Disaster Library</a></li>
                    <li><a href="{{ route('contacts.index') }}" class="hover:text-white transition-colors">Emergency Contacts</a></li>
                    <li><a href="{{ route('tips.index') }}" class="hover:text-white transition-colors">Community Tips</a></li>
                    <li><a href="{{ route('checklists.index') }}" class="hover:text-white transition-colors">My Checklists</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm mb-3">Emergency Numbers</h4>
                <ul class="space-y-1 text-sm font-mono">
                    <li><span class="text-orange-400">112</span> — National Emergency</li>
                    <li><span class="text-red-400">101</span> — Fire Brigade</li>
                    <li><span class="text-blue-400">100</span> — Police</li>
                    <li><span class="text-green-400">108</span> — Ambulance</li>
                </ul>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-gray-800 text-xs text-center">
            Built with Laravel · SafeGuard — Disaster Management Platform
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
