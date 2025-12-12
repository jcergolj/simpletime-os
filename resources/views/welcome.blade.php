<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Simple') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ tailwindcss('css/app.css') }}" rel="stylesheet" data-turbo-track="reload" />
</head>
<body class="min-h-screen">
    <!-- Navigation -->
    @if (Route::has('login'))
        <nav class="sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center gap-16">
                        <h1 class="text-xl font-display text-gray-900">{{ config('app.name', 'Simple') }}</h1>
                        <a href="https://github.com/jcergolj/simpletime-os" target="_blank" rel="noopener noreferrer" class="hidden md:flex items-center gap-2.5 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors group">
                            <svg class="h-5 w-5 transform group-hover:rotate-12 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                            </svg>
                            <span class="link-hover">GitHub</span>
                        </a>
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary px-6 py-2.5 rounded-xl text-sm">{{ __('Dashboard') }}</a>
                        @else
                            @if (Route::has('register') && !\App\Models\User::exists())
                                <a href="{{ route('register') }}" class="btn-primary px-6 py-2.5 rounded-xl text-sm">{{ __('Get Started') }}</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-gray-900 transition-colors hidden sm:inline-block link-hover">{{ __('Log in') }}</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    @endif

    <!-- Hero Section -->
    <section class="section-spacing gradient-bg overflow-hidden relative">
        <!-- Geometric Accents -->
        <div class="geometric-accent circle top-[20%] right-[15%]"></div>
        <div class="geometric-accent square bottom-[30%] left-[10%] [animation-delay:1s]"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-20 items-center">
                <div class="lg:col-span-6 space-y-8">
                    <div class="badge  stagger-1">
                        <span class="accent-dot"></span>
                        <span class="text-gray-800">Open Source • MIT Licensed</span>
                    </div>

                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-display mb-4 leading-[1.05]  stagger-2">
                        <span class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 bg-clip-text text-transparent">
                            {{ __('SimpleTime OS') }}
                        </span>
                    </h1>

                    <p class="text-2xl sm:text-3xl font-display text-gray-600 leading-[1.25]  stagger-3">
                        {{ __('Self-hosted time tracking for') }}
                        <span class="text-orange-500">{{ __('freelancers') }}</span>
                        {{ __('&') }}
                        <span class="text-blue-600">{{ __('developers') }}</span>
                    </p>

                    <p class="text-base text-gray-600 leading-relaxed max-w-lg  stagger-4">
                        {{ __('Track your work privately. Your data stays on your server. No subscriptions. A clean Laravel-powered time tracker for clients, projects, and reporting.') }}
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4  stagger-5">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-primary px-8 py-4 rounded-2xl text-center inline-flex items-center justify-center gap-2">
                                <span>{{ __('Go to Dashboard') }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        @else
                            @if (Route::has('register') && !\App\Models\User::exists())
                                <a href="{{ route('register') }}" class="btn-primary px-8 py-4 rounded-2xl text-center inline-flex items-center justify-center gap-2">
                                    <span>{{ __('Get Started') }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-secondary px-8 py-4 rounded-2xl text-center">
                                    {{ __('Sign In') }}
                                </a>
                            @endif
                        @endauth
                    </div>

                    <a href="https://github.com/jcergolj/simpletime-os#readme" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2.5 text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors group  stagger-6">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="link-hover">{{ __('View Installation Guide') }}</span>
                    </a>
                </div>

                <div class="lg:col-span-6  stagger-4">
                    <div class="screenshot-container relative">
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full opacity-20 blur-3xl"></div>
                        <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full opacity-20 blur-3xl"></div>
                        <img src="{{ asset('screenshots/dashboard.png') }}" alt="Dashboard preview" class="w-full h-auto relative z-10">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="bg-gradient-to-b from-white via-blue-50/30 to-white py-32 relative overflow-hidden">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-100 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-orange-100 rounded-full opacity-20 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-4xl sm:text-5xl font-display mb-4 bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                    {{ __('Built for Solo Developers') }}
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    {{ __('Everything you need to track time efficiently, nothing you don\'t.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="group bg-white p-8 rounded-3xl border-2 border-blue-100 hover:border-blue-300 transition-all duration-300 hover:shadow-xl hover:-translate-y-2  stagger-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl mb-3 text-gray-900">{{ __('Solo-Focused') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('Designed for one user—fast, simple, zero overhead.') }}</p>
                </div>

                <div class="group bg-white p-8 rounded-3xl border-2 border-orange-100 hover:border-orange-300 transition-all duration-300 hover:shadow-xl hover:-translate-y-2  stagger-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl mb-3 text-gray-900">{{ __('Forever Free') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('MIT license gives you full control—modify, share, and keep it.') }}</p>
                </div>

                <div class="group bg-white p-8 rounded-3xl border-2 border-green-100 hover:border-green-300 transition-all duration-300 hover:shadow-xl hover:-translate-y-2  stagger-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl mb-3 text-gray-900">{{ __('Click & Track') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('Timers start instantly—no friction, no delays.') }}</p>
                </div>

                <div class="group bg-white p-8 rounded-3xl border-2 border-purple-100 hover:border-purple-300 transition-all duration-300 hover:shadow-xl hover:-translate-y-2  stagger-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl mb-3 text-gray-900">{{ __('Minimalist Workflow') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('Only the essential tools—track time without distractions.') }}</p>
                </div>

                <div class="group bg-white p-8 rounded-3xl border-2 border-blue-100 hover:border-blue-300 transition-all duration-300 hover:shadow-xl hover:-translate-y-2  stagger-5">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl mb-3 text-gray-900">{{ __('Developer-Ready') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('Clean Laravel code that\'s easy to extend and audit.') }}</p>
                </div>

                <div class="group bg-white p-8 rounded-3xl border-2 border-orange-100 hover:border-orange-300 transition-all duration-300 hover:shadow-xl hover:-translate-y-2  stagger-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl mb-3 text-gray-900">{{ __('Focus-First Design') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('All key features in a clean, intuitive interface.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Sections -->
    <section class="section-spacing bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="space-y-40">
                <!-- Feature 1 -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-20 items-center">
                    <div class="lg:col-span-5 order-2 lg:order-1 animate-slide-in-left">
                        <div class="screenshot-container relative">
                            <div class="absolute -top-6 -left-6 w-32 h-32 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full opacity-15 blur-3xl"></div>
                            <img src="{{ asset('screenshots/start-tracking-with-new-client-dashboard.png') }}" alt="Creating a new client while starting timer" class="w-full h-auto relative z-10">
                        </div>
                    </div>

                    <div class="lg:col-span-7 order-1 lg:order-2 lg:pl-16  space-y-6">
                        <div class="inline-flex items-center gap-2 bg-purple-100 text-purple-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span>{{ __('Organization') }}</span>
                        </div>
                        <h2 class="text-4xl sm:text-5xl font-display leading-tight text-gray-900">
                            {{ __('Organize Your Work') }}
                            <span class="text-purple-600">{{ __('Clearly') }}</span>
                        </h2>
                        <p class="text-lg text-gray-600 leading-relaxed">
                            {{ __('Keep everything clean with simple client and project organization. Perfect for freelancers managing multiple clients and tracking billable hours.') }}
                        </p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-20 items-center">
                    <div class="lg:col-span-7 lg:pr-16 animate-slide-in-left space-y-6">
                        <div class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ __('Tracking') }}</span>
                        </div>
                        <h2 class="text-4xl sm:text-5xl font-display leading-tight text-gray-900">
                            {{ __('Track Time') }}
                            <span class="text-green-600">{{ __('Without Friction') }}</span>
                        </h2>
                        <p class="text-lg text-gray-600 leading-relaxed">
                            {{ __('One-click timers. Auto-save. Fast. Track your work without interrupting your flow. Start, pause, and log time entries in seconds.') }}
                        </p>
                    </div>

                    <div class="lg:col-span-5 ">
                        <div class="screenshot-container relative">
                            <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-br from-green-400 to-green-600 rounded-full opacity-15 blur-3xl"></div>
                            <img src="{{ asset('screenshots/time-running-dashboard.png') }}" alt="Active timer showing elapsed time and project details" class="w-full h-auto relative z-10">
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-20 items-center">
                    <div class="lg:col-span-5 order-2 lg:order-1 animate-slide-in-left">
                        <div class="screenshot-container relative">
                            <div class="absolute -top-6 -left-6 w-32 h-32 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full opacity-15 blur-3xl"></div>
                            <img src="{{ asset('screenshots/reports.png') }}" alt="Generate reports" class="w-full h-auto relative z-10">
                        </div>
                    </div>

                    <div class="lg:col-span-7 order-1 lg:order-2 lg:pl-16  space-y-6">
                        <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span>{{ __('Reporting') }}</span>
                        </div>
                        <h2 class="text-4xl sm:text-5xl font-display leading-tight text-gray-900">
                            {{ __('Understand Where') }}
                            <span class="text-blue-600">{{ __('Your Time Goes') }}</span>
                        </h2>
                        <p class="text-lg text-gray-600 leading-relaxed">
                            {{ __('Reports built for invoicing. See sum of total hours and amount per project instantly. CSV export included.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Philosophy Section -->
    <section class="bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 text-white section-spacing relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl "></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-orange-500 rounded-full filter blur-3xl " style="animation-delay: 2s;"></div>
        </div>

        <div class="max-w-5xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-display mb-8 leading-tight">
                    {{ __('Open Source') }}
                    <span class="bg-gradient-to-r from-blue-400 to-orange-400 bg-clip-text text-transparent">
                        {{ __('Time Tracking') }}
                    </span>
                </h2>

                <p class="text-xl text-blue-100 mb-6 leading-relaxed max-w-3xl mx-auto">
                    {{ __('SimpleTime OS is the self-hosted, open-source version for developers, freelancers, and consultants who want full control over their data.') }}
                </p>

                <p class="text-2xl font-display text-blue-300 mb-4">
                    {{ __('If you can install software on a server, this is made for you.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-left">
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:border-blue-400/30 transition-all duration-300">
                    <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-lg mb-3 text-white">{{ __('Single-User Focus') }}</h3>
                    <p class="text-blue-200 text-sm leading-relaxed">{{ __('One user, one purpose — zero bloat, everything stays simple.') }}</p>
                </div>

                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:border-orange-400/30 transition-all duration-300">
                    <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-lg mb-3 text-white">{{ __('Core Features Done Right') }}</h3>
                    <p class="text-blue-200 text-sm leading-relaxed">{{ __('10 features that work perfectly, instead of 1,000 that overwhelm.') }}</p>
                </div>

                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:border-green-400/30 transition-all duration-300">
                    <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-lg mb-3 text-white">{{ __('Self-Hosted & Private') }}</h3>
                    <p class="text-blue-200 text-sm leading-relaxed">{{ __('Your data stays on your server — fully under your control.') }}</p>
                </div>

                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:border-purple-400/30 transition-all duration-300">
                    <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-lg mb-3 text-white">{{ __('No Subscriptions') }}</h3>
                    <p class="text-blue-200 text-sm leading-relaxed">{{ __('One-time setup, no limits, no feature gates.') }}</p>
                </div>

                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:border-blue-400/30 transition-all duration-300">
                    <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-lg mb-3 text-white">{{ __('Developer-Friendly') }}</h3>
                    <p class="text-blue-200 text-sm leading-relaxed">{{ __('Clean Laravel 12 code you can learn from, extend, and audit.') }}</p>
                </div>

                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/10 hover:border-orange-400/30 transition-all duration-300">
                    <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-lg mb-3 text-white">{{ __('Open Source & Free') }}</h3>
                    <p class="text-blue-200 text-sm leading-relaxed">{{ __('MIT licensed — inspect, modify, and contribute freely.') }}</p>
                </div>
            </div>
        </div>
    </section>



    <!-- Roadmap Section -->
    <section class="section-spacing bg-gradient-to-b from-white via-orange-50/30 to-white relative overflow-hidden">
        <div class="absolute top-1/4 right-10 w-80 h-80 bg-orange-200 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute bottom-1/4 left-10 w-72 h-72 bg-blue-200 rounded-full opacity-20 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20">
                <div class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-100 to-blue-100 px-4 py-2 rounded-full text-sm font-semibold text-gray-800 mb-8">
                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span>{{ __('What\'s Next') }}</span>
                </div>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-display mb-6 text-gray-900">
                    {{ __('Coming') }}
                    <span class="bg-gradient-to-r from-orange-600 to-orange-500 bg-clip-text text-transparent">{{ __('Soon') }}</span>
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    {{ __('We\'re building features that expand SimpleTime OS while maintaining our core philosophy of simplicity.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <!-- API & Webhooks Card -->
                <div class="bg-white rounded-3xl p-10 feature-card relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full opacity-50 blur-2xl"></div>

                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>

                        <h3 class="text-3xl font-display mb-3 text-gray-900">{{ __('API & Webhooks') }}</h3>
                        <p class="text-gray-600 leading-relaxed mb-8">
                            {{ __('Programmatic access to your time tracking data. Integrate SimpleTime OS with your existing tools and workflows.') }}
                        </p>

                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('RESTful API endpoints for all resources') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Webhook notifications for timer events') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Token-based authentication') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Integrate with invoicing, project management, and more') }}</span>
                            </li>
                        </ul>

                        <div class="bg-blue-50 border-2 border-blue-100 rounded-2xl p-5">
                            <p class="text-sm text-gray-700 leading-relaxed">
                                <span class="font-semibold text-blue-900">{{ __('Perfect for:') }}</span>
                                {{ __('Developers who want to automate workflows and connect SimpleTime OS to their existing tools.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- SaaS Hosted Version Card -->
                <div class="bg-white rounded-3xl p-10 feature-card relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full opacity-50 blur-2xl"></div>

                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                            </svg>
                        </div>

                        <h3 class="text-3xl font-display mb-3 text-gray-900">{{ __('SaaS Hosted Version') }}</h3>
                        <p class="text-gray-600 leading-relaxed mb-8">
                            {{ __('Don\'t want to self-host? We\'ll handle all the technical details for you. Same simplicity, zero server management.') }}
                        </p>

                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-orange-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Fully managed hosting - we handle everything') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-orange-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Automatic updates and security patches') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-orange-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Daily backups included') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-orange-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ __('Start tracking in under 60 seconds') }}</span>
                            </li>
                        </ul>

                        <div class="bg-orange-50 border-2 border-orange-100 rounded-2xl p-5">
                            <p class="text-sm text-gray-700 leading-relaxed">
                                <span class="font-semibold text-orange-900">{{ __('Perfect for:') }}</span>
                                {{ __('Freelancers and consultants who want simplicity without the technical setup.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <div class="bg-gradient-to-br from-white to-blue-50/50 border-2 border-blue-200 rounded-3xl p-12 max-w-2xl mx-auto relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-200 rounded-full opacity-30 blur-2xl"></div>
                    <div class="relative z-10">
                        <p class="text-xl font-display text-gray-900 mb-6">
                            {{ __('Interested in these features?') }}
                        </p>
                        <a href="https://github.com/jcergolj/simpletime-os" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-3 btn-secondary px-8 py-4 rounded-2xl group">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ __('Star on GitHub to stay updated') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-b from-white to-gray-50 border-t-2 border-blue-100 py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <h3 class="font-display text-2xl mb-4 text-gray-900">{{ config('app.name', 'Simple') }}</h3>
                    <p class="text-gray-600 leading-relaxed mb-6 max-w-md">
                        {{ __('Open source time tracking for developers and freelancers who value simplicity and privacy.') }}
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="https://github.com/jcergolj/simpletime-os" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-900 hover:bg-blue-600 rounded-xl flex items-center justify-center transition-all duration-300 group">
                            <svg class="w-5 h-5 text-white group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="font-display text-sm font-bold text-gray-900 mb-5 uppercase tracking-wider">{{ __('Resources') }}</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="https://github.com/jcergolj/simpletime-os" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-blue-600 transition-colors inline-flex items-center gap-2 group">
                                <span>{{ __('GitHub Repository') }}</span>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://github.com/jcergolj/simpletime-os#readme" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-blue-600 transition-colors inline-flex items-center gap-2 group">
                                <span>{{ __('Documentation') }}</span>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://github.com/jcergolj/simpletime-os/issues" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-blue-600 transition-colors inline-flex items-center gap-2 group">
                                <span>{{ __('Report Issues') }}</span>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transform translate-x-0 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Info -->
                <div>
                    <h4 class="font-display text-sm font-bold text-gray-900 mb-5 uppercase tracking-wider">{{ __('Project') }}</h4>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ __('MIT Licensed') }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ __('Built with Laravel 12') }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ __('Self-Hosted') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-8 border-t-2 border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-500 text-sm">
                        © {{ date('Y') }} <span class="font-semibold text-gray-700">{{ config('app.name', 'Simple') }}</span>. {{ __('All rights reserved.') }}
                    </p>
                    <p class="text-gray-500 text-sm">
                        {{ __('Made with') }} <span class="text-red-500">♥</span> {{ __('for developers') }}
                    </p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
