<x-layouts.app :title="__('Time Entries')">
    <div class="space-y-8" data-controller="inline-edit">
        <!-- Page Header -->
        <div class="px-4 sm:px-0">
            <h1 class="font-display" style="font-size: 48px; margin-bottom: 8px; color: var(--color-text);">{{ __('Time Entries') }}</h1>
            <p style="font-size: 18px; color: var(--color-text-secondary); font-weight: 400;">{{ __('Track and manage your time entries') }}</p>
        </div>

        <!-- Filters Section -->
        <div class="card mx-4 sm:mx-0" style="padding: 32px 28px;">
            <h3 class="font-display" style="font-size: 22px; margin-bottom: 24px; color: var(--color-text);">{{ __('Filters') }}</h3>
            <form method="GET" action="{{ route('time-entries.index') }}">
                <!-- Mobile/Tablet: Stacked layout -->
                <div class="block xl:hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="label">{{ __('Client') }}</label>
                            <select name="client_id" class="input-field">
                                <option value="">{{ __('All Clients') }}</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="label">{{ __('Project') }}</label>
                            <turbo-frame id="project-filter-mobile" src="{{ route('project-filter', ['client_id' => request('client_id'), 'selected_project_id' => request('project_id')]) }}" loading="lazy">
                                <select name="project_id" class="input-field" style="background: var(--bg); font-size: 15px;" disabled>
                                    <option value="">{{ request('client_id') ? __('Loading projects...') : __('Select a client first') }}</option>
                                </select>
                            </turbo-frame>
                        </div>
                        <div>
                            <label class="label">{{ __('From Date') }}</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                   class="input-field">
                        </div>
                        <div>
                            <label class="label">{{ __('To Date') }}</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                   class="input-field">
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <x-icon-button>
                            <x-slot:icon>
                                <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                            </x-slot:icon>
                            {{ __('Filter') }}
                        </x-icon-button>
                        <a href="{{ route('time-entries.index') }}" style="color: var(--text-secondary); padding: 14px 24px; font-weight: 600; transition: color 0.2s; text-align: center; text-decoration: none; display: flex; align-items: center; justify-center;">
                            {{ __('Clear Filters') }}
                        </a>
                    </div>
                </div>

                <!-- Desktop XL: Single line layout -->
                <div class="hidden xl:block">
                    <div class="flex items-end gap-4">
                        <div class="flex-1">
                            <label class="label">{{ __('Client') }}</label>
                            <select name="client_id" class="input-field">
                                <option value="">{{ __('All Clients') }}</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <label class="label">{{ __('Project') }}</label>
                            <turbo-frame id="project-filter-desktop" src="{{ route('project-filter', ['client_id' => request('client_id'), 'selected_project_id' => request('project_id')]) }}" loading="lazy">
                                <select name="project_id" class="input-field" style="background: var(--bg); font-size: 15px;" disabled>
                                    <option value="">{{ request('client_id') ? __('Loading projects...') : __('Select a client first') }}</option>
                                </select>
                            </turbo-frame>
                        </div>
                        <div class="flex-1">
                            <label class="label">{{ __('From Date') }}</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                   class="input-field">
                        </div>
                        <div class="flex-1">
                            <label class="label">{{ __('To Date') }}</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                   class="input-field">
                        </div>
                        <div class="flex gap-3">
                            <x-icon-button style="white-space: nowrap;">
                                <x-slot:icon>
                                    <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                </x-slot:icon>
                                {{ __('Filter') }}
                            </x-icon-button>
                            <a href="{{ route('time-entries.index') }}" style="color: var(--text-secondary); padding: 14px 24px; font-weight: 600; transition: color 0.2s; text-decoration: none; display: flex; align-items: center; white-space: nowrap;">
                                {{ __('Clear Filters') }}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Add Time Entry Section -->
        <div class="card mx-4 sm:mx-0" style="padding: 32px 28px;">
            <turbo-frame id="time-entry-create-form">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <div>
            <h2 class="text-lg sm:text-xl font-medium text-gray-900 mb-1">{{ __('Manual Time Entry') }}</h2>
            <p class="text-gray-600 text-sm sm:text-base">{{ __('Add time entries with specific start and end times, client, and project details.') }}</p>
        </div>
        <x-icon-link :href="route('time-entries.create')">
            {{ __('Add Manual Entry') }}
        </x-icon-link>
    </div>
</turbo-frame>

        </div>

        <!-- Time Entries List -->
        <turbo-frame id="time-entries-lists">
            @include('turbo::time-entries.list', ['timeEntries' => $timeEntries])
        </turbo-frame>
    </div>

    <script>
        // Handle client selection change - reload project filter turbo frames
        document.querySelectorAll('select[name="client_id"]').forEach(function(clientSelect) {
            clientSelect.addEventListener('change', function() {
                const selectedClientId = this.value;
                const currentProjectId = document.querySelector('select[name="project_id"]')?.value || '';
                const filterUrl = '{{ route('project-filter') }}?client_id=' + selectedClientId + '&selected_project_id=' + currentProjectId;

                // Update both mobile and desktop turbo frames
                document.getElementById('project-filter-mobile')?.setAttribute('src', filterUrl);
                document.getElementById('project-filter-desktop')?.setAttribute('src', filterUrl);
                document.getElementById('project-filter-mobile')?.reload();
                document.getElementById('project-filter-desktop')?.reload();
            });
        });
    </script>
</x-layouts.app>
