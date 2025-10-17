<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Simple') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600" rel="stylesheet" />
    <link href="{{ tailwindcss('css/app.css') }}" rel="stylesheet" data-turbo-track="reload" />
</head>
<body class="min-h-screen bg-white">
    <!-- Navigation -->
    @if (Route::has('login'))
        <nav class="border-b border-gray-100">
            <div class="mx-auto px-2 sm:px-4 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-6">
                        <h1 class="text-lg font-medium text-gray-900">{{ config('app.name', 'Simple') }}</h1>
                        <a href="https://github.com/jcergolj/simple" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-gray-900 transition-colors flex items-center space-x-2">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium">GitHub</span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-gray-900 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-800 transition-colors">{{ __('Dashboard') }}</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors">{{ __('Log in') }}</a>
                            @if (Route::has('register') && !\App\Models\User::exists())
                                <a href="{{ route('register') }}" class="bg-gray-900 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-800 transition-colors">{{ __('Register') }}</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    @endif

    <!-- Hero Section -->
    <div class="bg-gradient-to-b from-white to-gray-50">
        <div class="mx-auto px-2 sm:px-4 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl sm:text-6xl font-bold text-gray-900 mb-6">{{ __('Simple Time OS') }}</h1>
                    <p class="text-xl sm:text-2xl text-gray-600 mb-12">{{ __('Track your time easily.') }}</p>

                    <div class="flex flex-col sm:flex-row lg:flex-col gap-4 items-center lg:items-start">
                        @auth
                            <a href="{{ route('dashboard') }}" class="bg-gray-900 text-white px-8 py-3 rounded-md font-medium hover:bg-gray-800 transition-colors text-center">
                                {{ __('Go to Dashboard') }}
                            </a>
                        @else
                            @if (Route::has('register') && !\App\Models\User::exists())
                                <a href="{{ route('register') }}" class="bg-gray-900 text-white px-8 py-3 rounded-md font-medium hover:bg-gray-800 transition-colors text-center">
                                    {{ __('Get Started') }}
                                </a>
                            @endif
                            <a href="{{ route('login') }}" class="border border-gray-300 text-gray-700 px-8 py-3 rounded-md font-medium hover:bg-gray-50 transition-colors text-center">
                                {{ __('Sign In') }}
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="rounded-xl overflow-hidden shadow-2xl border border-gray-200 flex items-center justify-center bg-gray-50">
                    <img src="{{ asset('screenshots/dashboard.png') }}" alt="Dashboard preview" class="w-full h-auto">
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <div class="rounded-xl overflow-hidden shadow-2xl border border-gray-200 flex items-center justify-center bg-gray-50">
                    <img src="{{ asset('screenshots/start-tracking-with-new-client-dashboard.png') }}" alt="Creating a new client while starting timer" class="w-full h-auto">
                </div>

                <div class="text-center lg:text-left">
                    <h1 class="text-2xl sm:text-4xl font-bold text-gray-900 mb-6">{{ __('Add new client & projects instantly') }}</h1>
                    <p class="text-xl sm:text-2xl text-gray-600 mb-12">{{ __('Add new clients and projects instantly while tracking time.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <div class="text-center lg:text-left">
                    <h1 class="text-2xl sm:text-4xl font-bold text-gray-900 mb-6">{{ __('Focus on Work, Not Tracking') }}</h1>
                    <p class="text-xl sm:text-2xl text-gray-600 mb-12">
                        {{ __('See your timer running in real-time. Start, stop, and manage your work sessions with ease.') }}
                    </p>
                </div>

                <div class="rounded-xl overflow-hidden shadow-2xl border border-gray-200 flex items-center justify-center bg-gray-50">
                    <img src="{{ asset('screenshots/time-running-dashboard.png') }}" alt="Active timer showing elapsed time and project details" class="w-full h-auto">
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <div class="rounded-xl overflow-hidden shadow-2xl border border-gray-200 flex items-center justify-center bg-gray-50">
                    <img src="{{ asset('screenshots/reports.png') }}" alt="Generate reports" class="w-full h-auto">
                </div>

                <div class="text-center lg:text-left">
                    <h1 class="text-2xl sm:text-4xl font-bold text-gray-900 mb-6">{{ __('Generate reports') }}</h1>
                    <p class="text-xl sm:text-2xl text-gray-600 mb-12">{{ __('Summarise total time spent by client or project. Easily export your data as CSV.') }}</p>
                </div>
            </div>

            <!-- Philosophy Section -->
            <div class="max-w-4xl mx-auto text-center py-20 px-4">
                <h2 class="text-3xl sm:text-5xl font-bold text-gray-900 mb-8">{{ __('Open Source Time Tracking') }}</h2>

                <p class="text-xl text-gray-700 mb-6 leading-relaxed">
                    {{ __('SimpleTime OS is the open-source, self-hosted version for developers, freelancers, and consultants who want full control over their data.') }}
                    <span class="font-semibold text-gray-900">{{ __('If you\'re comfortable installing software on a server, this is for you.') }}</span>
                </p>

                <div class="bg-gray-50 rounded-2xl p-8 sm:p-12 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                        <div class="flex items-start space-x-3">
                            <svg class="h-6 w-6 text-gray-900 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">{{ __('One user. One purpose. Zero bloat.') }}</p>
                                <p class="text-gray-600 text-sm">{{ __('Single-user design keeps everything simple') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <svg class="h-6 w-6 text-gray-900 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">{{ __('Core time tracking done exceptionally well') }}</p>
                                <p class="text-gray-600 text-sm">{{ __('10 features that work perfectly > 1,000 that overwhelm') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <svg class="h-6 w-6 text-gray-900 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">{{ __('Self-hosted - your data stays yours') }}</p>
                                <p class="text-gray-600 text-sm">{{ __('Privacy-focused and fully under your control') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <svg class="h-6 w-6 text-gray-900 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">{{ __('No subscriptions, no limits, no feature gates') }}</p>
                                <p class="text-gray-600 text-sm">{{ __('One-time setup, own it forever') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <svg class="h-6 w-6 text-gray-900 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">{{ __('Ideal for PHP & Laravel developers') }}</p>
                                <p class="text-gray-600 text-sm">{{ __('Clean Laravel 12 codebase you can learn from and extend') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <svg class="h-6 w-6 text-gray-900 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">{{ __('Open source & MIT licensed') }}</p>
                                <p class="text-gray-600 text-sm">{{ __('Free forever. Inspect, modify, and contribute.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-900 text-white rounded-xl p-6 sm:p-8">
                    <p class="text-lg sm:text-xl leading-relaxed">
                        {{ __('This open-source version is perfect if you\'re tech-savvy and want complete control.') }}
                    </p>
                    <p class="text-lg sm:text-xl font-semibold mt-4">
                        {{ __('Not comfortable with self-hosting? A managed SaaS version is coming soon — same simplicity, zero server setup.') }}
                    </p>
                </div>
            </div>

            <!-- Tech Stack Section -->
            <div class="bg-gray-900 py-20 px-4">
                <div class="max-w-6xl mx-auto">
                    <h2 class="text-3xl sm:text-5xl font-bold text-white text-center mb-6">{{ __('Built with PHP & Laravel') }}</h2>
                    <p class="text-xl text-gray-300 text-center mb-12 max-w-3xl mx-auto">
                        {{ __('SimpleTime OS is built with modern Laravel 12 and follows Laravel best practices. Perfect for PHP developers who want a clean, well-architected codebase to learn from or extend.') }}
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                        <!-- Backend -->
                        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                            <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                                <svg class="h-6 w-6 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                </svg>
                                {{ __('Backend') }}
                            </h3>
                            <ul class="space-y-2 text-gray-300">
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('Laravel 12') }}
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('PHP 8.4') }}
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('SQLite / MySQL / PostgreSQL') }}
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('PHPUnit & Pest testing') }}
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('Laravel Pint & Larastan') }}
                                </li>
                            </ul>
                        </div>

                        <!-- Frontend -->
                        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                            <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                                <svg class="h-6 w-6 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('Frontend') }}
                            </h3>
                            <ul class="space-y-2 text-gray-300">
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('Hotwire Turbo') }}
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('Stimulus JavaScript') }}
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('Tailwind CSS + DaisyUI') }}
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('Blade Templates') }}
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('Importmap (no build step)') }}
                                </li>
                            </ul>
                        </div>

                        <!-- Developer Tools -->
                        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
                            <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                                <svg class="h-6 w-6 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                                {{ __('Developer Tools') }}
                            </h3>
                            <ul class="space-y-2 text-gray-300">
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('Laravel Sail (Docker)') }}
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('Rector refactoring') }}
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('Comprehensive tests') }}
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('Factories & seeders') }}
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-500 mr-2">▸</span>
                                    {{ __('Artisan CLI tools') }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-gray-800 border border-gray-700 rounded-xl p-8 text-center">
                        <p class="text-xl text-white mb-4">
                            <span class="font-bold">{{ __('Perfect for Laravel developers') }}</span>
                        </p>
                        <p class="text-lg text-gray-300 max-w-3xl mx-auto">
                            {{ __('Clean architecture following Laravel conventions. Well-tested, documented, and easy to extend. Great for learning modern Laravel patterns or as a foundation for your own projects.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Roadmap Section -->
            <div class="pt-20 pb-12 px-4">
                <div class="max-w-6xl mx-auto">
                    <h2 class="text-3xl sm:text-5xl font-bold text-gray-900 text-center mb-8">{{ __('Coming Soon') }}</h2>
                    <p class="text-xl text-gray-600 text-center mb-20 max-w-2xl mx-auto leading-relaxed">
                        {{ __('We\'re building features that expand SimpleTime OS while maintaining our core philosophy of simplicity.') }}
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- API & Webhooks Card -->
                        <div class="bg-white border-2 border-gray-200 rounded-2xl p-8 hover:border-gray-900 transition-colors">
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="bg-gray-900 text-white rounded-xl p-4">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ __('API & Webhooks') }}</h3>
                            </div>

                            <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                                {{ __('Programmatic access to your time tracking data. Integrate SimpleTime OS with your existing tools and workflows.') }}
                            </p>

                            <ul class="space-y-3 mb-6">
                                <li class="flex items-start space-x-3">
                                    <svg class="h-6 w-6 text-gray-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ __('RESTful API endpoints for all resources') }}</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="h-6 w-6 text-gray-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ __('Webhook notifications for timer events') }}</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="h-6 w-6 text-gray-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ __('Token-based authentication') }}</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="h-6 w-6 text-gray-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ __('Integrate with invoicing, project management, and more') }}</span>
                                </li>
                            </ul>

                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold text-gray-900">{{ __('Perfect for:') }}</span>
                                    {{ __('Developers who want to automate workflows and connect SimpleTime OS to their existing tools.') }}
                                </p>
                            </div>
                        </div>

                        <!-- SaaS Hosted Version Card -->
                        <div class="bg-white border-2 border-gray-200 rounded-2xl p-8 hover:border-gray-900 transition-colors">
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="bg-gray-900 text-white rounded-xl p-4">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ __('SaaS Hosted Version') }}</h3>
                            </div>

                            <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                                {{ __('Don\'t want to self-host? We\'ll handle all the technical details for you. Same simplicity, zero server management.') }}
                            </p>

                            <ul class="space-y-3 mb-6">
                                <li class="flex items-start space-x-3">
                                    <svg class="h-6 w-6 text-gray-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ __('Fully managed hosting - we handle everything') }}</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="h-6 w-6 text-gray-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ __('Automatic updates and security patches') }}</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="h-6 w-6 text-gray-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ __('Daily backups included') }}</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <svg class="h-6 w-6 text-gray-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ __('Start tracking in under 60 seconds') }}</span>
                                </li>
                            </ul>

                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold text-gray-900">{{ __('Perfect for:') }}</span>
                                    {{ __('Freelancers and consultants who want simplicity without the technical setup.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 text-center">
                        <p class="text-gray-600 text-lg">
                            {{ __('Interested in these features?') }}
                            <a href="https://github.com/jcergolj/simple" target="_blank" rel="noopener noreferrer" class="text-gray-900 font-semibold hover:underline">
                                {{ __('Star the project on GitHub') }}
                            </a>
                            {{ __('to stay updated.') }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-100">
        <div class="mx-auto px-2 sm:px-4 lg:px-8 py-12 text-center">
            <p class="text-gray-600">{{ config('app.name', 'Simple') }} © {{ date('Y') }}</p>
        </div>
    </footer>
</body>
</html>
