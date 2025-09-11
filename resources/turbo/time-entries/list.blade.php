<div class="card mx-4 sm:mx-0" style="padding: 0;">
    <x-list.header
        :title="__('Your Time Entries')"
        :items="$timeEntries"
        :singularLabel="__('entry')"
        :pluralLabel="__('entries')"
    />

    @forelse($timeEntries as $timeEntry)
        <turbo-frame id="time-entry-{{ $timeEntry->id }}">
            <div style="padding: 28px 32px; border-bottom: 1px solid var(--border);" class="last:border-b-0">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <!-- Time Entry Info -->
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div>
                            <div class="entry-label">{{ __('Date') }}</div>
                            <div class="entry-value"><x-user-date :date="$timeEntry->start_time" /></div>
                        </div>
                        <div>
                            <div class="entry-label">{{ __('Duration') }}</div>
                            <div class="entry-value">
                                @if($timeEntry->formattedDuration)
                                    {{ $timeEntry->formattedDuration }}
                                @else
                                    <span style="color: var(--accent);">{{ __('Running...') }}</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="entry-label">{{ __('Time') }}</div>
                            <div class="entry-value">
                                <x-user-time :time="$timeEntry->start_time" />
                                @if($timeEntry->end_time)
                                    - <x-user-time :time="$timeEntry->end_time" />
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="entry-label">{{ __('Rate') }}</div>
                            <div class="entry-value">
                                @if($timeEntry->getEffectiveHourlyRate())
                                    {{ $timeEntry->getEffectiveHourlyRate()->formatted() }}/hr
                                @else
                                    <span style="color: var(--text-muted);">-</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="entry-label">{{ __('Earned') }}</div>
                            <div class="entry-amount" style="text-align: left;">
                                @if($timeEntry->calculateEarnings())
                                    {{ $timeEntry->calculateEarnings()->formatted() }}
                                @else
                                    <span style="color: var(--text-muted);">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <x-list.action-buttons
                        :edit-route="route('time-entries.edit', $timeEntry)"
                        :delete-route="route('time-entries.destroy', $timeEntry)"
                        :confirm-message="__('Are you sure you want to delete this time entry?')"
                        :show-edit="(bool) $timeEntry->duration"
                    />
                </div>

                <!-- Client/Project row below -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    @if($timeEntry->client)
                        <div>
                            <div class="entry-label">{{ __('Client') }}</div>
                            <div class="entry-value">{{ $timeEntry->client->name }}</div>
                        </div>
                    @endif

                    @if($timeEntry->project)
                        <div>
                            <div class="entry-label">{{ __('Project') }}</div>
                            <div class="entry-value">{{ $timeEntry->project->name }}</div>
                        </div>
                    @endif
                </div>

                <!-- Notes -->
                @if($timeEntry->notes)
                    <div style="margin-top: 12px; padding: 16px; background: var(--bg); border-radius: 10px;">
                        <div class="entry-label">{{ __('Notes') }}</div>
                        <p style="font-size: 15px; color: var(--text-secondary); margin-top: 4px;">{{ $timeEntry->notes }}</p>
                    </div>
                @endif
            </div>
        </turbo-frame>
    @empty
        <x-list.empty-state
            :title="__('No time entries yet')"
            :description="__('Get started by tracking your first time entry above.')"
            :action-route="route('time-entries.create')"
            :action-text="__('Add Your First Time Entry')"
            turbo-frame="time-entry-create-form">
            <x-slot:icon>
                <svg style="width: 32px; height: 32px; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </x-slot:icon>
        </x-list.empty-state>
    @endforelse

    @if($timeEntries->hasPages())
        <div style="padding: 20px 32px; border-top: 1px solid var(--border);">
            {{ $timeEntries->links() }}
        </div>
    @endif
</div>
