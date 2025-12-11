<turbo-frame id="client-{{ $client->id }}">
  <div class="p-6 bg-base-50 border-b border-base-200 last:border-b-0">
    <div class="card bg-base-100 shadow-lg">
      <div class="card-body space-y-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
          <div>
            <h3 class="card-title text-xl">{{ __('Edit Client') }}</h3>
            <p class="text-base-content/70">{{ __('Update client information and default hourly rate.') }}</p>
          </div>
        </div>

        <!-- Form -->
        <form action="{{ route('clients.update', $client->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Client Name -->
                <div class="form-control">
                    <label class="label" for="name">
                        <span class="label-text font-semibold">{{ __('Client Name') }}</span>
                        <span class="label-text-alt text-error">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" id="name" name="name" value="{{ old('name', $client->name) }}"
                            placeholder="{{ __('Enter client name (e.g., Acme Corporation)') }}"
                            class="input input-bordered input-lg w-full pl-12 text-lg @error('name') input-error @enderror" required autofocus />
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-6 w-6 text-base-content/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    <x-form.error for="name" />
                </div>

                <!-- Hourly Rate -->
                <div class="form-control">
                    <label class="label" for="hourly_rate_amount">
                        <span class="label-text font-semibold">{{ __('Hourly Rate') }}</span>
                        <span class="label-text-alt text-base-content/50">{{ __('Optional') }}</span>
                    </label>
                    <x-form.hourly-rate :client="$client" />
                    <x-form.error for="hourly_rate.amount" />
                    <x-form.error for="hourly_rate.currency" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-2 mt-4">
                <x-form.button.cancel :href="route('clients.index')" turboFrame="client-edit-form">{{ __('Cancel') }}</x-form.button.cancel>
                <x-form.button.save text="{{ __('Update Client') }}" />
            </div>
        </form>

      </div>
    </div>
  </div>
</turbo-frame>
