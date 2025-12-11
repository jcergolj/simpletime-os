<turbo-frame id="timer-widget" class="contents">
    <div class="card bg-base-100 shadow-lg"
         data-controller="timer keyboard-shortcuts"
         data-timer-running-value="true"
         data-timer-start-time-value="{{ $runningTimer->start_time->timestamp }}">
        <div class="card-body space-y-6">

            <!-- Header with Cancel Button -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
                <div>
                    <h3 class="card-title text-xl">{{ __('Edit Running Session') }}</h3>
                    <p class="text-base-content/70">{{ __('Update client, project, and start time for your active session.') }}</p>
                </div>
                <a href="{{ route('dashboard') }}"
                   data-turbo-frame="timer-widget"
                   class="inline-flex items-center justify-center w-10 h-10 rounded-lg hover:bg-base-200 transition-colors"
                   title="{{ __('Cancel') }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>

            <!-- Running Time Display - Prominent -->
            <div class="text-center py-8 px-4 rounded-2xl bg-gradient-to-br from-base-200/50 to-base-100 border border-base-300">
                <div class="text-7xl font-mono font-bold tracking-tight" data-timer-target="display">00:00:00</div>
                <div class="mt-4 text-sm font-medium text-base-content/60 uppercase tracking-wider">{{ __('Active Session') }}</div>
            </div>

            <!-- Edit Form -->
            <form action="{{ route('running-timer-session.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Client and Project Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">{{ __('Client') }}</span>
                        </label>
                        <x-form.search-clients
                            searchId="edit-timer-session"
                            :client="$runningTimer->client"
                        />
                        <x-form.error for="client_id" />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">{{ __('Project') }}</span>
                        </label>
                        <x-form.search-projects
                            searchId="edit-timer-session"
                            :project="$runningTimer->project"
                        />
                        <x-form.error for="project_id" />
                    </div>
                </div>

                <!-- Start Time -->
                <div class="form-control">
                    <label class="label" for="start_time">
                        <span class="label-text font-semibold">{{ __('Start Time') }}</span>
                        <span class="label-text-alt text-base-content/50">{{ __('Cannot be in future') }}</span>
                    </label>
                    <input
                        type="datetime-local"
                        id="start_time"
                        name="start_time"
                        value="{{ old('start_time', $runningTimer->start_time->format('Y-m-d\TH:i')) }}"
                        max="{{ now()->format('Y-m-d\TH:i') }}"
                        class="input input-bordered input-lg w-full text-lg @error('start_time') input-error @enderror"
                        required
                    >
                    <x-form.error for="start_time" />
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-2 pt-4">
                    <x-form.button.cancel :href="route('dashboard')" turboFrame="timer-widget">{{ __('Cancel') }}</x-form.button.cancel>
                    <x-form.button.save text="{{ __('Save Changes') }}" />
                </div>
            </form>
        </div>
    </div>
</turbo-frame>
