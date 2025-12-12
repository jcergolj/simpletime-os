<turbo-frame id="timer-widget" class="contents">
    <div class="card-timer bg-white border border-base-300 mx-4 sm:mx-0 min-h-[252px] lg:min-h-[312px]">
        <div class="relative px-4 py-4 lg:px-6 lg:py-5 min-h-[216px] lg:min-h-[276px] flex flex-col"
             data-controller="timer keyboard-shortcuts"
             data-timer-running-value="true"
             data-timer-start-time-value="{{ $runningTimer->start_time->timestamp }}">

            <!-- Top Controls: Back button (right) -->
            <div class="flex justify-end items-start -mt-4 -mx-4 lg:-mt-5 lg:-mx-6 mb-1.5 lg:mb-2">
                <x-form.button.cancel :href="route('dashboard')" turboFrame="timer-widget">{{ __('Cancel') }}</x-form.button.cancel>
            </div>

            <!-- Center Content: Timer -->
            <div class="text-center space-y-1.5 lg:space-y-2 mb-2 lg:mb-3">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Edit Running Session') }}</p>
                <div class="text-5xl lg:text-7xl font-mono font-bold text-gray-900 tracking-tight" data-timer-target="display">00:00:00</div>
            </div>

            <!-- Edit Form -->
            <form action="{{ route('running-timer-session.update') }}" method="POST" data-turbo-frame="_top" class="space-y-2 lg:space-y-3">
                @csrf
                @method('PUT')

                <!-- Client, Project, and Start Time Row -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-2 lg:gap-3">
                    <div class="w-full">
                        <x-form.search-clients
                            searchId="edit-timer-session"
                            :client="$runningTimer->client"
                        />
                    </div>

                    <div class="w-full">
                        <x-form.search-projects
                            searchId="edit-timer-session"
                            :project="$runningTimer->project"
                        />
                    </div>

                    <div class="w-full">
                        <input
                            type="datetime-local"
                            id="start_time"
                            name="start_time"
                            value="{{ old('start_time', $runningTimer->start_time->format('Y-m-d\TH:i')) }}"
                            max="{{ now()->format('Y-m-d\TH:i') }}"
                            class="input-field @error('start_time') border-red-500 @enderror"
                            title="{{ __('Start Time') }}"
                            required
                        >
                    </div>
                </div>

                <!-- Error Messages -->
                <div class="space-y-1">
                    <x-form.error for="client_id" />
                    <x-form.error for="project_id" />
                    <x-form.error for="start_time" />
                </div>

                <!-- Save Button (Centered) -->
                <div class="flex justify-center pt-1.5 lg:pt-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 lg:px-6 py-2 lg:py-2.5 rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 inline-flex items-center justify-center gap-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm lg:text-base">{{ __('Save Changes') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</turbo-frame>
