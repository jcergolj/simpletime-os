<turbo-frame id="time-entry-{{ $timeEntry->id }}">
  <div class="card-body space-y-6">

    <!-- Header -->
    <div class="mb-4">
      <h2 class="card-title text-xl mb-1">{{ __('Edit Time Entry') }}</h2>
      <p class="text-base-content/70">{{ __('Update time tracking information for this entry.') }}</p>
    </div>

    <!-- Form -->
    <form action="{{ route('time-entries.update', $timeEntry) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')
      @if($is_recent)
        <input type="hidden" name="is_recent" value="1">
        @endif
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <x-form.search-clients
            searchId="edit-time-entry-{{ $timeEntry->id }}"
            :client="$timeEntry->client"
          />
        </div>

        <div>
          <x-form.search-projects
            searchId="edit-time-entry-{{ $timeEntry->id }}"
            :project="$timeEntry->project"
          />
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Start Time') }}</label>
          <input
            type="datetime-local"
            id="start_time"
            name="start_time"
            value="{{ old('start_time', $timeEntry->start_time?->format('Y-m-d\TH:i')) }}"
            class="w-full px-4 py-4 text-lg border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('start_time') border-red-500 @enderror"
            required
          >
            <x-form.error for="start_time" />
        </div>

        <div>
          <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">{{ __('End Time') }}</label>
          <input
            type="datetime-local"
            id="end_time"
            name="end_time"
            value="{{ old('end_time', $timeEntry->end_time?->format('Y-m-d\TH:i')) }}"
            class="w-full px-4 py-4 text-lg border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('end_time') border-red-500 @enderror"
          >
            <x-form.error for="end_time" />
          </div>
        </div>

      <div>
        <label for="hourly_rate_amount" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Hourly Rate') }}</label>
        <x-form.hourly-rate
          :project="$timeEntry->project"
          :client="$timeEntry->client"
        />
        <p class="mt-1 text-sm text-gray-600">{{ __('Leave empty to use project/client rate') }}</p>

        <x-form.error for="hourly_rate.amount" />
        <x-form.error for="hourly_rate.currency" />
      </div>

       <div>
        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Notes') }}</label>
        <textarea
          id="notes"
          name="notes"
          rows="3"
          class="w-full px-4 py-4 text-lg border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('notes') border-red-500 @enderror"
          placeholder="{{ __('Optional notes about this time entry...') }}"
        >{{ old('notes', $timeEntry->notes) }}</textarea>
        <x-form.error for="notes" />
      </div>

      
      <div class="flex gap-3 justify-end">
        @if ($is_recent)
            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 px-6 py-3 font-medium transition-colors inline-flex items-center" data-turbo-frame="recent-entry-{{ $timeEntry->id }}">
            {{ __('Cancel') }}
            </a>
        @else
            <x-form.button.cancel :href="route('time-entries.index')" turboFrame="time-entry-edit-form">{{ __('Cancel') }}</x-form.button.cancel>
        @endif
        
        <x-form.button.save text="{{ __('Update Time Entry') }}" />
      </div>
    </form>

  </div>
</turbo-frame>
