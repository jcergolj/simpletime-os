<x-layouts.app :title="__('Time Tracking Dashboard')">
    <div class="space-y-8">
        <!-- Header -->
        <div class="px-4 sm:px-0">
            <h1 class="font-display" style="font-size: 48px; margin-bottom: 8px; color: var(--color-text);">{{ __('Dashboard') }}</h1>
            <p style="font-size: 18px; color: var(--color-text-secondary); font-weight: 400;">{{ __('Weekly overview and time tracking') }}</p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 px-4 sm:px-0">
            <turbo-frame id="weekly-hours">
                <x-dashboard.weekly-hours />
            </turbo-frame>

            <turbo-frame id="weekly-earnings">
                <x-dashboard.weekly-earnings />
            </turbo-frame>
        </div>

        <!-- Timer Section -->
        <turbo-frame id="timer-widget" class="contents">
        <div class="card mx-4 sm:mx-0 justify-center" style="padding: 40px; min-height: 520px;">
            @if($runningTimer)
                <div class="p-8"
         data-controller="timer keyboard-shortcuts"
         data-timer-running-value="true"
         data-timer-start-time-value="{{ $runningTimer->start_time->timestamp ?? $timeEntry->start_time->timestamp }}">
        <div class="text-center space-y-6">
                <!-- Session Status with Edit Button -->
                <div class="flex justify-between items-center mb-4 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">{{ __('Session in progress') }}</h2>
                    <a href="{{ route('running-timer-session.destroy') }}"
                       data-turbo-method="delete"
                       data-turbo-frame="_top"
                       class="text-gray-500 hover:text-gray-700 text-sm font-medium underline transition-colors"
                       data-keyboard-shortcuts-target="cancelButton"
                       data-turbo-confirm="{{ __('Are you sure you want to cancel this timer? All progress will be lost.') }}"
                       title="{{ __('Cancel Timer') }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    </a>
                </div>

                <!-- Running Time Display -->
                <div class="text-6xl font-mono font-bold text-black" data-timer-target="display">00:00:00</div>

                <!-- Client and Project Info - Side by Side -->
                <div class="flex justify-center items-center gap-4">
                    @if($runningTimer->client)
                        <div class="inline-flex items-center px-6 py-3 rounded-full text-2xl bg-green-100 text-black border border-green-200">
                            <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="font-bold">{{ $runningTimer->client->name }}</span>
                        </div>
                    @endif

                    @if($runningTimer->project)
                        <div class="inline-flex items-center px-6 py-3 rounded-full text-2xl bg-blue-100 text-black border border-blue-200">
                            <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="font-bold">{{ $runningTimer->project->name }}</span>
                        </div>
                    @endif

                    @if(!$runningTimer->client && !$runningTimer->project)
                        <div class="inline-flex items-center px-6 py-3 rounded-full text-2xl bg-gray-100 text-black border border-gray-200">
                            <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="font-bold">{{ __('No client or project assigned') }}</span>
                        </div>
                    @endif
                </div>

                <!-- Control Buttons -->
                <div class="flex flex-col sm:flex-row justify-center gap-4 pt-4">
                    <a href="{{ route('running-timer-session.completion') }}"
                       data-turbo-method="post"
                       data-turbo-frame="_top"
                       class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 flex items-center justify-center space-x-3"
                       data-keyboard-shortcuts-target="stopButton"
                       title="{{ __('Stop Timer') }} (Ctrl+Shift+T)">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <rect x="6" y="6" width="12" height="12" rx="1"></rect>
                        </svg>
                        <span class="text-lg">{{ __('Stop Timer') }}</span>
                        <span class="text-red-200 text-sm">(Ctrl+Shift+T)</span>
                    </a>
                </div>

                <!-- Cancel Action (Less Prominent) -->
                <div class="mt-4 text-center">
                    <a href="{{ route('running-timer-session.edit') }}"
                       data-turbo-frame="timer-widget"
                       class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center space-x-1"
                       title="{{ __('Edit Timer') }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>{{ __('Edit') }}</span>
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
</turbo-frame>
            @else
                 <div class="p-8 flex items-center justify-center" data-controller="keyboard-shortcuts">
            <div class="text-center w-full">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">{{ __('Start New Timer') }}</h2>

                    <form action="{{ route('running-timer-session.store') }}" method="POST" data-turbo-frame="_top">
                        @csrf

                        <!-- Client and Project Selection Row -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
                            <div class="w-full">
                                <x-form.search-clients :client="$lastEntry?->client" />
                            </div>

                            <div class="w-full">
                                <x-form.search-projects :project="$lastEntry?->project" />
                            </div>
                        </div>

                        <!-- Start Timer Button Row -->
                        <div class="flex justify-center">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-medium flex items-center justify-center space-x-2 sm:space-x-3 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" data-keyboard-shortcuts-target="startButton" title="{{ __('Start Timer') }} (Ctrl+Shift+S)">
                                <svg class="h-8 w-8 sm:h-12 sm:w-12" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                                <span class="text-sm sm:text-base">{{ __('Start Timer') }}</span>
                                <span class="text-green-200 text-xs sm:text-sm hidden sm:inline">(Ctrl+Shift+S)</span>
                            </button>
                        </div>

                        <!-- Error Messages -->
                        <div class="mt-4 space-y-2">
                            <x-form.error for="client_id" />
                            <x-form.error for="project_id" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
            @endif
        </div>

        <!-- Recent Entries -->
        <div class="px-4 sm:px-0">
            <turbo-frame id="recent-entries">
                @include('dashboard.recent-entries', ['recentEntries' => $recentEntries])
            </turbo-frame>
        </div>
    </div>
</x-layouts.app>
