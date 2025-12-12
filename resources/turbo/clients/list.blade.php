<div class="card mx-4 sm:mx-0" style="padding: 0;">
    <x-list.header
        :title="__('Your Clients')"
        :items="$clients"
        :singularLabel="__('client')"
        :pluralLabel="__('clients')"
    />

    @forelse($clients as $client)
        <turbo-frame id="client-{{ $client->id }}">
        <div style="padding: 28px 32px; border-bottom: 1px solid var(--border);" class="last:border-b-0">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <!-- Client Info -->
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <div class="entry-label">{{ __('Client Name') }}</div>
                        <div class="entry-value">{{ $client->name }}</div>
                    </div>
                    <div>
                        <div class="entry-label">{{ __('Hourly Rate') }}</div>
                        <div class="entry-value">
                            @if($client->hourlyRate?->amount)
                                {{ $client->hourlyRate->formatted() }}/hr
                            @else
                                <span style="color: var(--text-muted);">{{ __('No rate set') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <x-list.action-buttons
                    :edit-route="route('clients.edit', $client)"
                    :delete-route="route('clients.destroy', $client)"
                    :confirm-message="__('Are you sure you want to delete this client?')"
                />
            </div>
        </div>
        </turbo-frame>
    @empty
        <x-list.empty-state
            :title="__('No clients yet')"
            :description="__('Get started by adding your first client above.')"
            :action-route="route('clients.create')"
            :action-text="__('Add Your First Client')">
            <x-slot:icon>
                <svg style="width: 32px; height: 32px; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </x-slot:icon>
        </x-list.empty-state>
    @endforelse

    @if($clients->hasPages())
        <div style="padding: 20px 32px; border-top: 1px solid var(--border);">
            {{ $clients->links() }}
        </div>
    @endif
</div>
