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
                                <a href="{{ route('register') }}" class="btn-primary px-6 py-2.5 rounded-xl text-sm">{{ __('Install in 5 Minutes') }}</a>
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
                        <span class="text-gray-800">Open Source • O'Saasy Licensed</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ __('Free to self-host forever. SaaS rights reserved.') }}</p>

                    <div class="space-y-2">
                        <div class="stagger-1">
                            <span class="text-2xl sm:text-3xl lg:text-4xl font-display text-gray-900">
                                {{ __('SimpleTime') }}
                            </span>
                            <span class="text-2xl sm:text-3xl lg:text-4xl text-gray-400 ml-2">{{ __('—') }}</span>
                        </div>

                        <h1 class="stagger-2">
                            <div class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-display leading-tight">
                                <span class="text-gray-700 font-semibold">{{ __('don\'t spend') }}</span>
                                <span class="bg-gradient-to-r from-blue-600 via-blue-700 to-purple-600 bg-clip-text text-transparent">
                                    {{ __(' time') }}
                                </span>
                            </div>
                            <div class="text-3xl sm:text-4xl lg:text-5xl font-display leading-tight mt-1">
                                <span class="text-gray-600">{{ __('tracking') }}</span>
                                <span class="bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent font-bold">
                                    {{ __(' time') }}
                                </span>
                                <span class="text-gray-600">{{ __('. ') }}</span>
                            </div>
                        </h1>
                    </div>

                    <p class="text-lg text-gray-700 leading-relaxed max-w-2xl mb-4  stagger-3">
                        {{ __('Most time trackers overwhelm you with 100+ features you\'ll never use. SimpleTime OS gives you exactly what you need—timer, clients, projects, reports—nothing more.') }}
                    </p>

                    <p class="text-base text-gray-600 leading-relaxed max-w-xl  stagger-4">
                        {{ __('Self-host in 5 minutes. Own your data forever. Pay nothing.') }}
                    </p>

                    <div class="mt-6  stagger-4">
                        <div class="text-lg text-gray-700 font-medium mb-2">{{ __('4 Core Features:') }}</div>
                        <div class="flex flex-wrap items-center gap-4 text-base">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                <span class="font-semibold text-gray-900">{{ __('Timer') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-green-600"></span>
                                <span class="font-semibold text-gray-900">{{ __('Clients') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-orange-600"></span>
                                <span class="font-semibold text-gray-900">{{ __('Projects') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-purple-600"></span>
                                <span class="font-semibold text-gray-900">{{ __('Reports') }}</span>
                            </div>
                        </div>
                        <div class="text-lg text-gray-600 mt-4">
                            <span class="font-bold text-orange-600">{{ __('∞') }}</span> {{ __('Years Free') }}
                        </div>
                    </div>

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
                                    <span>{{ __('Install in 5 Minutes') }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </a>
                                <p class="text-sm text-gray-500 text-center sm:text-left">{{ __('5-minute install • No credit card') }}</p>
                            @else
                                <a href="{{ route('login') }}" class="btn-secondary px-8 py-4 rounded-2xl text-center">
                                    {{ __('Sign In') }}
                                </a>
                            @endif
                        @endauth
                    </div>

                    <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600  stagger-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span><strong class="text-gray-900">{{ __('Open Source') }}</strong></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span><strong class="text-gray-900">{{ __('O\'Saasy') }}</strong> {{ __('licensed') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                            <span><strong class="text-gray-900">{{ __('Laravel 12') }}</strong></span>
                        </div>
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
                    {{ __('Built for Solo Freelancers') }}
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    {{ __('Whether you\'re a developer, designer, consultant, or any solo professional—track time efficiently with nothing you don\'t need.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Card 1: No Subscription Trap -->
                <div class="group bg-white p-8 rounded-3xl border-2 border-orange-100 hover:border-orange-300 transition-all duration-300 hover:shadow-xl hover:-translate-y-2  stagger-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl mb-3 text-gray-900">{{ __('No Subscription Trap') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('O\'Saasy licensed—self-host, modify, and keep it forever. One-time setup, no recurring fees, no vendor lock-in.') }}</p>
                </div>

                <!-- Card 2: Built for Solo Work -->
                <div class="group bg-white p-8 rounded-3xl border-2 border-blue-100 hover:border-blue-300 transition-all duration-300 hover:shadow-xl hover:-translate-y-2  stagger-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl mb-3 text-gray-900">{{ __('Built for Solo Work') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('No team features cluttering your workflow. Just you, your clients, and billable hours—nothing else in the way.') }}</p>
                </div>

                <!-- Supporting Card 1: Start in 2 Clicks -->
                <div class="group bg-white p-8 rounded-3xl border-2 border-green-100 hover:border-green-300 transition-all duration-300 hover:shadow-xl hover:-translate-y-2  stagger-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl mb-3 text-gray-900">{{ __('Start in 2 Clicks') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('Timers start instantly—no friction, no delays.') }}</p>
                </div>

                <!-- Supporting Card 2: Audit Every Line -->
                <div class="group bg-white p-8 rounded-3xl border-2 border-purple-100 hover:border-purple-300 transition-all duration-300 hover:shadow-xl hover:-translate-y-2  stagger-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl mb-3 text-gray-900">{{ __('Audit Every Line') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('Clean Laravel code that\'s easy to extend and audit. All key features in a clean, intuitive interface.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Strengths Section -->
    <section class="py-24 bg-gradient-to-b from-white via-blue-50/20 to-white relative overflow-hidden">
        <div class="absolute top-1/4 left-10 w-96 h-96 bg-blue-100 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute bottom-1/4 right-10 w-80 h-80 bg-orange-100 rounded-full opacity-20 blur-3xl"></div>

        <div class="max-w-5xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-display mb-4 text-gray-900">
                    {{ __('Complete Control,') }} <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">{{ __('Zero Compromises') }}</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    {{ __('Self-host on your terms. Own your data. Pay nothing, forever.') }}
                </p>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-white border-4 border-blue-600 rounded-3xl p-12 shadow-2xl relative">
                <div class="absolute -top-4 -right-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                    {{ __('SELF-HOSTED POWER') }}
                </div>

                <div class="grid md:grid-cols-2 gap-x-12 gap-y-6 mb-10">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg text-gray-900 mb-1">{{ __('$0 Forever') }}</h3>
                            <p class="text-sm text-gray-600">{{ __('O\'Saasy licensed—no subscriptions, no recurring fees, ever') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg text-gray-900 mb-1">{{ __('Complete Data Ownership') }}</h3>
                            <p class="text-sm text-gray-600">{{ __('Your server, your database, your rules—guaranteed privacy') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg text-gray-900 mb-1">{{ __('4 Essential Features') }}</h3>
                            <p class="text-sm text-gray-600">{{ __('Timer, Clients, Projects, Reports—nothing you don\'t need') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg text-gray-900 mb-1">{{ __('Zero Vendor Pressure') }}</h3>
                            <p class="text-sm text-gray-600">{{ __('No limits, no upsells, no upgrade prompts—just your tracker') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg text-gray-900 mb-1">{{ __('Open Source') }}</h3>
                            <p class="text-sm text-gray-600">{{ __('Audit every line, customize freely, extend however you want') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg text-gray-900 mb-1">{{ __('No Vendor Lock-In') }}</h3>
                            <p class="text-sm text-gray-600">{{ __('Export, migrate, or move your data anywhere, anytime') }}</p>
                        </div>
                    </div>
                </div>

                <div class="text-center pt-6 border-t-2 border-blue-200">
                    @if (Route::has('register') && !\App\Models\User::exists())
                        <a href="{{ route('register') }}" class="btn-primary px-10 py-4 rounded-2xl inline-block text-lg">
                            {{ __('Install in 5 Minutes') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary px-10 py-4 rounded-2xl inline-block text-lg">
                            {{ __('Get Started') }}
                        </a>
                    @endif
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
                            {{ __('See Your') }}
                            <span class="text-blue-600">{{ __('Billable Hours') }}</span>
                        </h2>
                        <p class="text-lg text-gray-600 leading-relaxed">
                            {{ __('Reports show exactly how many billable hours you worked per client or project. Filter by date, export to CSV, and share clean reports with clients for invoicing and transparency.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Self-Hosting Made Simple Section -->
    <section class="py-24 bg-gradient-to-b from-blue-50 via-white to-blue-50 relative overflow-hidden">
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-blue-200 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-green-200 rounded-full opacity-20 blur-3xl"></div>

        <div class="max-w-6xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-display mb-4 text-gray-900">
                    {{ __('But Isn\'t Self-Hosting Hard?') }}
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    {{ __('If you can clone a Git repo, you can install SimpleTime OS.') }}
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Column: Installation Code -->
                <div class="order-2 md:order-1">
                    <div class="bg-gray-900 rounded-2xl p-8 shadow-2xl">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="ml-2 text-sm text-gray-400">{{ __('install.sh') }}</span>
                        </div>
                        <pre class="text-green-400 text-sm font-mono leading-relaxed"><code>git clone https://github.com/jcergolj/simpletime-os
cd simpletime-os
./install.sh
php artisan app:create-user
php artisan serve

<span class="text-gray-500"># Done. You're tracking time.</span></code></pre>
                    </div>
                </div>

                <!-- Right Column: Reassurance -->
                <div class="order-1 md:order-2 space-y-6">
                    <div class="bg-white rounded-2xl p-8 border-2 border-blue-100">
                        <h3 class="text-2xl font-display mb-6 text-gray-900">
                            {{ __('Ready in 5 Minutes') }}
                        </h3>

                        <ul class="space-y-4 mb-6">
                            <li class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <strong class="text-gray-900">{{ __('Single install script') }}</strong>
                                    <p class="text-sm text-gray-600">{{ __('One command sets everything up') }}</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <strong class="text-gray-900">{{ __('Works on any PHP 8.4+ server') }}</strong>
                                    <p class="text-sm text-gray-600">{{ __('Linux, macOS, Windows') }}</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <strong class="text-gray-900">{{ __('SQLite default') }}</strong>
                                    <p class="text-sm text-gray-600">{{ __('No database setup needed') }}</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <strong class="text-gray-900">{{ __('Multiple hosting options') }}</strong>
                                    <p class="text-sm text-gray-600">{{ __('Your laptop, DigitalOcean, Forge, office server') }}</p>
                                </div>
                            </li>
                        </ul>

                        <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
                            <p class="text-sm text-gray-700 leading-relaxed">
                                <span class="font-semibold text-blue-900">{{ __('Cost to self-host:') }}</span>
                                {{ __('$0 (laptop) to $5/month (DigitalOcean)') }}
                            </p>
                        </div>
                    </div>

                    <div class="text-center md:text-left">
                        <a href="https://github.com/jcergolj/simpletime-os#readme" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 btn-primary px-8 py-4 rounded-2xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span>{{ __('View Full Installation Guide') }}</span>
                        </a>
                    </div>
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
                        {{ __('Open source time tracking for solo freelancers who value simplicity and privacy.') }}
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
                            <span>{{ __('O\'Saasy Licensed') }}</span>
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
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
