<turbo-frame id="project-create-form">
  <div class="card-body space-y-6">

    <!-- Header -->
    <div class="mb-4">
      <h2 class="card-title text-xl mb-1">{{ __('Create New Project') }}</h2>
      <p class="text-base-content/70">{{ __('Fill in the details below to add a new project to your system.') }}</p>
    </div>

    <!-- Form -->
    <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
      @csrf

      <!-- Project Name, Client, and Hourly Rate in One Row -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Project Name -->
        <div class="form-control">
          <label class="label" for="name">
            <span class="label-text font-semibold">{{ __('Project Name') }}</span>
            <span class="label-text-alt text-error">*</span>
          </label>
          <div class="relative">
            <input type="text" id="name" name="name" value="{{ old('name') }}"
              placeholder="{{ __('Enter project name') }}"
              class="input input-bordered input-lg w-full pl-12 text-lg @error('name') input-error @enderror" required autofocus />
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <svg class="h-6 w-6 text-base-content/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
              </svg>
            </div>
          </div>
          <x-form.error for="name" />
        </div>

        <!-- Client -->
        <div class="form-control">
          <label class="label">
            <span class="label-text font-semibold">{{ __('Client') }}</span>
          </label>
          <x-form.search-clients
            searchId="create-project"
            :clientId="old('client_id')"
            placeholder="{{ __('Search or create client...') }}"
          />
          <x-form.error for="client_id" />
        </div>

        <!-- Hourly Rate -->
        <div class="form-control">
          <label class="label" for="hourly_rate_amount">
            <span class="label-text font-semibold">{{ __('Hourly Rate') }}</span>
            <span class="label-text-alt text-base-content/50">{{ __('Optional') }}</span>
          </label>
          <x-form.hourly-rate />
          <span class="label-text-alt text-base-content/50">{{ __('Override client rate') }}</span>
          <x-form.error for="hourly_rate_amount" />
          <x-form.error for="hourly_rate_currency" />
        </div>
      </div>

      <!-- Form Actions -->
      <div class="flex gap-2 justify-end">
        <x-form.button.cancel :href="route('projects.index')" turboFrame="project-create-form">{{ __('Cancel') }}</x-form.button.cancel>
        <x-form.button.save text="{{ __('Create Project') }}"  />
      </div>
    </form>
  </div>
</turbo-frame>
