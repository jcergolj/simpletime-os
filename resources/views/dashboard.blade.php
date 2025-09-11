<x-layouts.app :title="__('Time Tracking Dashboard')">
    <div class="space-y-3 lg:space-y-8">
        <!-- Header -->
        <div class="px-4 sm:px-0">
            <h1 class="font-display page-heading">{{ __('Dashboard') }}</h1>
            <p class="page-subheading">{{ __('Weekly overview and time tracking') }}</p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-1 lg:gap-6 px-4 sm:px-0">
            <x-dashboard.weekly-hours />

            <x-dashboard.weekly-earnings />
        </div>

        <!-- Timer Section -->
        <div class="px-4 sm:px-0">
            @if($runningTimer)
                @include('turbo::timer-sessions.running', ['runningTimer' => $runningTimer])
            @else
                <turbo-frame id="timer-widget" class="contents">
                    <div class="card-timer bg-white border border-base-300 mx-4 sm:mx-0 min-h-[252px] lg:min-h-[312px] flex items-center justify-center">
                        <div class="flex items-center justify-center w-full" data-controller="keyboard-shortcuts">
                            <div class="text-center w-full">
                                <h2 class="text-base lg:text-lg font-bold text-gray-900 mb-2 lg:mb-3">{{ __('Start New Timer') }}</h2>

                                <form action="{{ route('running-timer-session.store') }}" method="POST" data-turbo-frame="_top">
                                    @csrf

                                    <!-- Client and Project Selection Row -->
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 lg:gap-3 mb-2 lg:mb-3">
                                        <div class="w-full">
                                            <x-form.search-clients :client="$lastEntry?->client" />
                                        </div>

                                        <div class="w-full">
                                            <x-form.search-projects :project="$lastEntry?->project" />
                                        </div>
                                    </div>

                                    <!-- Start Timer Button Row -->
                                    <div class="flex justify-center">
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 lg:px-5 py-2 lg:py-2.5 rounded-lg font-medium inline-flex items-center justify-center gap-2 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" data-keyboard-shortcuts-target="startButton" title="{{ __('Start Timer') }} (Ctrl+Shift+S)">
                                            <svg class="h-6 w-6 lg:h-7 lg:w-7" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                            <span class="text-sm">{{ __('Start Timer') }}</span>
                                            <span class="text-green-200 text-xs hidden sm:inline">(Ctrl+Shift+S)</span>
                                        </button>
                                    </div>

                                    <!-- Error Messages -->
                                    <div class="mt-2 space-y-1">
                                        <x-form.error for="client_id" />
                                        <x-form.error for="project_id" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </turbo-frame>
            @endif
        </div>

        <!-- Recent Entries -->
        <div class="px-4 sm:px-0 mt-8">
            @include('dashboard.recent-entries', ['recentEntries' => $recentEntries])
        </div>
    </div>
</x-layouts.app>
