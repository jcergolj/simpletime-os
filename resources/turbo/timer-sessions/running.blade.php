<turbo-frame id="timer-widget" class="contents">
    <div class="card-timer bg-white border border-base-300 mx-4 sm:mx-0 min-h-[252px] lg:min-h-[312px]">
        <div class="relative px-4 py-4 lg:px-6 lg:py-5 min-h-[216px] lg:min-h-[276px] flex flex-col"
             data-controller="timer keyboard-shortcuts"
             data-timer-running-value="true"
             data-timer-start-time-value="{{ $runningTimer->start_time->timestamp }}">

            <div>
                <!-- Top Controls: Edit (left) and Cancel (right) -->
                <div class="flex justify-between items-start -mt-4 -mx-4 lg:-mt-5 lg:-mx-6 mb-1.5 lg:mb-2">
                    <a href="{{ route('running-timer-session.edit') }}"
                       data-turbo-frame="timer-widget"
                       class="inline-flex items-center px-4 py-2 rounded-lg border border-transparent hover:border-base-300 transition-colors font-medium text-base-content/70 hover:text-base-content"
                       title="{{ __('Edit Timer') }}">
                        {{ __('Edit') }}
                    </a>

                    <form action="{{ route('running-timer-session.destroy') }}" method="POST" class="inline" data-turbo-frame="_top">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 rounded-lg border border-transparent hover:border-base-300 transition-colors font-medium text-base-content/70 hover:text-base-content"
                                data-keyboard-shortcuts-target="cancelButton"
                                onclick="return confirm('{{ __('Are you sure you want to cancel this timer? All progress will be lost.') }}')">
                            {{ __('Cancel') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Client and Project Info - Top Area -->
            <div class="flex flex-wrap justify-center items-center gap-1.5 mb-2 lg:mb-3">
                @if($runningTimer->client)
                    <div class="inline-flex items-center px-2 py-0.5 lg:px-2.5 lg:py-1 rounded-md text-xs bg-green-50 text-green-900 border border-green-200/50">
                        <svg class="h-3 w-3 lg:h-3.5 lg:w-3.5 mr-1 lg:mr-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="font-semibold">{{ $runningTimer->client->name }}</span>
                    </div>
                @endif

                @if($runningTimer->project)
                    <div class="inline-flex items-center px-2 py-0.5 lg:px-2.5 lg:py-1 rounded-md text-xs bg-blue-50 text-blue-900 border border-blue-200/50">
                        <svg class="h-3 w-3 lg:h-3.5 lg:w-3.5 mr-1 lg:mr-1.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="font-semibold">{{ $runningTimer->project->name }}</span>
                    </div>
                @endif

                @if(!$runningTimer->client && !$runningTimer->project)
                    <div class="inline-flex items-center px-2 py-0.5 lg:px-2.5 lg:py-1 rounded-md text-xs bg-gray-50 text-gray-600 border border-gray-200/50">
                        <svg class="h-3 w-3 lg:h-3.5 lg:w-3.5 mr-1 lg:mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="font-medium">{{ __('No client or project assigned') }}</span>
                    </div>
                @endif
            </div>

            <!-- Center Content: Timer -->
            <div class="flex-1 flex flex-col items-center justify-center text-center">
                <div class="space-y-2 lg:space-y-3">
                    <p class="text-xs lg:text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('Session in progress') }}</p>
                    <div class="text-5xl lg:text-7xl font-mono font-bold text-gray-900 tracking-tight" data-timer-target="display">00:00:00</div>
                </div>
            </div>

            <!-- Bottom Action: Stop Button (Centered) -->
            <div class="flex justify-center pt-2 lg:pt-3">
                <a href="{{ route('running-timer-session.completion') }}"
                   data-turbo-method="post"
                   data-turbo-frame="_top"
                   class="bg-red-600 hover:bg-red-700 text-white px-4 lg:px-6 py-2 lg:py-2.5 rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 inline-flex items-center justify-center gap-2"
                   data-keyboard-shortcuts-target="stopButton"
                   title="{{ __('Stop Timer') }} (Ctrl+Shift+T)">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <rect x="6" y="6" width="12" height="12" rx="1"></rect>
                    </svg>
                    <span class="text-sm lg:text-base">{{ __('Stop Timer') }}</span>
                    <span class="text-red-200 text-xs">(Ctrl+Shift+T)</span>
                </a>
            </div>
        </div>
    </div>
</turbo-frame>
