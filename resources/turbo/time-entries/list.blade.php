<div class="card mx-4 sm:mx-0" style="padding: 0;">
    <div style="padding: 28px 32px; border-bottom: 1px solid var(--border);">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h3 style="font-size: 28px; font-weight: 600; color: var(--text); margin-bottom: 4px;">{{ __('Your Time Entries') }}</h3>
                <p style="font-size: 14px; color: var(--text-secondary);">{{ $timeEntries->total() }} {{ Str::plural(__('entry'), $timeEntries->total()) }} {{ __('total') }}</p>
            </div>
            @if($timeEntries->hasPages())
                <div style="font-size: 14px; color: var(--text-secondary);">
                    {{ __('Showing') }} {{ $timeEntries->firstItem() }}-{{ $timeEntries->lastItem() }} {{ __('of') }} {{ $timeEntries->total() }}
                </div>
            @endif
        </div>
    </div>

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
                    <div class="flex items-center gap-2">
                        @if($timeEntry->duration)
                            <a href="{{ route('time-entries.edit', $timeEntry) }}" style="padding: 8px 16px; background: var(--accent); color: white; border-radius: 8px; font-size: 14px; font-weight: 500; line-height: 1; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; border: none;">
                                <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span style="line-height: 1;">{{ __('Edit') }}</span>
                            </a>
                        @endif

                        <a href="{{ route('time-entries.destroy', $timeEntry) }}"
                           style="padding: 8px 16px; background: white; color: var(--text); border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; font-weight: 500; line-height: 1; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;"
                           data-turbo-method="delete"
                           data-turbo-confirm="{{ __('Are you sure you want to delete this time entry?') }}"
                           data-turbo-frame="_top">
                            <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span style="line-height: 1;">{{ __('Delete') }}</span>
                        </a>
                    </div>
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
        <div style="padding: 64px 32px; text-align: center;">
            <div style="width: 64px; height: 64px; margin: 0 auto 16px; background: var(--bg); border-radius: 50%; display: flex; align-items: center; justify-center;">
                <svg style="width: 32px; height: 32px; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px; color: var(--text);">{{ __('No time entries yet') }}</h3>
            <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 20px;">{{ __('Get started by tracking your first time entry above.') }}</p>
            <a href="{{ route('time-entries.create') }}"
               style="padding: 12px 24px; background: var(--accent); color: white; border-radius: 8px; font-size: 15px; font-weight: 500; line-height: 1; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; border: none;"
               data-turbo-frame="time-entry-create-form">
                <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span style="line-height: 1;">{{ __('Add Your First Time Entry') }}</span>
            </a>
        </div>
    @endforelse

    @if($timeEntries->hasPages())
        <div style="padding: 20px 32px; border-top: 1px solid var(--border);">
            {{ $timeEntries->links() }}
        </div>
    @endif
</div>
