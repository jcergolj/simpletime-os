@props(['runningTimer' => null, 'lastEntry' => null])

<turbo-frame id="timer-widget" class="contents">
    @if($runningTimer)
        @include('turbo::timer-sessions.running', ['runningTimer' => $runningTimer])
    @else
        <div class="p-0" data-controller="keyboard-shortcuts">
            <div class="text-center">
                <h2 class="text-lg font-bold text-gray-900 mb-3">{{ __('Start New Timer') }}</h2>

                    <form action="{{ route('running-timer-session.store') }}" method="POST" data-turbo-frame="timer-widget">
                        @csrf

                        <!-- Client and Project Selection Row -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-3">
                            <div class="w-full">
                                <x-form.search-clients :client="$lastEntry?->client" />
                            </div>

                            <div class="w-full">
                                <x-form.search-projects :project="$lastEntry?->project" />
                            </div>
                        </div>

                        <!-- Start Timer Button Row -->
                        <div class="flex justify-center">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium flex items-center justify-center space-x-2 sm:space-x-3 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" data-keyboard-shortcuts-target="startButton" title="{{ __('Start Timer') }} (Ctrl+Shift+S)">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
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
</turbo-frame>
