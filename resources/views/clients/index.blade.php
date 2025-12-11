<x-layouts.app :title="__('Clients')">
    <div class="space-y-8" data-controller="inline-edit">
        <!-- Page Header -->
        <div class="px-4 sm:px-0 animate-fade-in-up">
            <h1 class="font-display" style="font-size: 48px; margin-bottom: 8px; color: var(--color-text);">{{ __('Clients') }}</h1>
            <p style="font-size: 18px; color: var(--color-text-secondary); font-weight: 400;">{{ __('Manage your clients and their hourly rates') }}</p>
        </div>

        <!-- Search Filter -->
        <div class="card mx-4 sm:mx-0 animate-fade-in-up stagger-1" style="padding: 32px 28px;">
            <h3 class="font-display" style="font-size: 22px; margin-bottom: 24px; color: var(--color-text);">{{ __('Search Clients') }}</h3>
            <form method="GET" action="{{ route('clients.index') }}">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <label class="label">{{ __('Search by name') }}</label>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="{{ __('Enter client name...') }}"
                               class="input-field">
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-end space-y-2 sm:space-y-0 sm:space-x-3">
                        <button type="submit" class="btn-primary sm:w-auto" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; line-height: 1;">
                            <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span style="line-height: 1;">{{ __('Search') }}</span>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('clients.index') }}" style="color: var(--text-secondary); padding: 14px 24px; font-weight: 600; transition: color 0.2s; text-align: center; text-decoration: none; display: inline-block;">
                                {{ __('Clear') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Add Client Section -->
        <div class="card mx-4 sm:mx-0 animate-fade-in-up stagger-2" style="padding: 32px 28px;">
            <turbo-frame id="client-create-form">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div>
                        <h2 class="font-display" style="font-size: 22px; margin-bottom: 8px; color: var(--color-text);">{{ __('Add New Client') }}</h2>
                        <p style="font-size: 16px; color: var(--color-text-secondary);">{{ __('Create a new client profile with billing information') }}</p>
                    </div>
                    <a href="{{ route('clients.create') }}" class="btn-primary sm:w-auto" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; line-height: 1; text-decoration: none;">
                        <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span style="line-height: 1;">{{ __('Add Client') }}</span>
                    </a>
                </div>
            </turbo-frame>
        </div>

        <!-- Clients List -->
        <turbo-frame id="clients-lists">
            @include('turbo::clients.list', ['clients' => $clients])
        </turbo-frame>
    </div>
    
</x-layouts.app>
