<turbo-frame id="timer-widget" class="contents">
    <div class="p-8"
         data-controller="timer keyboard-shortcuts"
         data-timer-running-value="true"
         data-timer-start-time-value="{{ $runningTimer->start_time->timestamp }}">
        <!-- Cancel Button - Top Right -->
        <div class="flex justify-end mb-2">
            <a href="{{ route('dashboard') }}"
               data-turbo-frame="timer-widget"
               class="text-gray-500 hover:text-gray-700 transition-colors"
               title="{{ __('Cancel') }}">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>

        <div class="text-center space-y-6">
            <!-- Session Status -->
            <div class="text-lg font-medium text-gray-700">{{ __('Edit Running Session') }}</div>

            <!-- Running Time Display -->
            <div class="text-6xl font-mono font-bold text-black" data-timer-target="display">00:00:00</div>

            <!-- Edit Form -->
            <form action="{{ route('turbo.running-timer-session.update') }}" method="POST" data-turbo-frame="timer-widget" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Client and Project Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Client') }}</label>
                        <x-form.search-clients
                            searchId="edit-timer-session"
                            :client="$runningTimer->client"
                        />
                    </div>

                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Project') }}</label>
                        <x-form.search-projects
                            searchId="edit-timer-session"
                            :project="$runningTimer->project"
                        />
                    </div>
                </div>

                <!-- Start Time -->
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Start Time') }}</label>
                    <input
                        type="datetime-local"
                        id="start_time"
                        name="start_time"
                        value="{{ old('start_time', $runningTimer->start_time->format('Y-m-d\TH:i')) }}"
                        max="{{ now()->format('Y-m-d\TH:i') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('start_time') border-red-500 @enderror"
                        required
                    >
                    <div class="mt-1">
                        <p class="text-sm text-gray-600">{{ __('Current session start time. Cannot be set to future.') }}</p>
                    </div>
                    <x-form.error for="start_time" />
                </div>

                <!-- Error Messages -->
                <div class="space-y-2">
                    <x-form.error for="client_id" />
                    <x-form.error for="project_id" />
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-center gap-4 pt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center justify-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-lg">{{ __('Save Changes') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</turbo-frame>
