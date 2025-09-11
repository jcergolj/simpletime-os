<div class="card" style="padding: 0;">
    <div style="padding: 20px 24px; border-bottom: 1px solid var(--border);">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 style="font-size: 20px; font-weight: 600; color: var(--text); margin-bottom: 4px;">{{ __('Recent Time Entries') }}</h3>
                <p style="font-size: 14px; color: var(--text-secondary);">{{ __('Your latest time tracking activity') }}</p>
            </div>
            <a href="{{ route('time-entries.index') }}" class="btn-secondary" style="display: inline-flex; align-items: center; gap: 6px; line-height: 1; text-decoration: none; font-size: 14px;" data-turbo-frame="_top">
                <span style="line-height: 1;">{{ __('View all') }}</span>
                <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
    <div style="border-bottom: 1px solid var(--border);" class="last:border-b-0">
        @forelse($recentEntries->take(5) as $entry)
            <x-recent-time-entry :entry="$entry" :running-timer="$runningTimer ?? null" />
        @empty
            <div style="padding: 64px 32px; text-align: center;">
                <div style="width: 64px; height: 64px; margin: 0 auto 16px; background: var(--bg); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 32px; height: 32px; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h4 style="font-size: 18px; font-weight: 600; margin-bottom: 8px; color: var(--text);">{{ __('No time entries yet') }}</h4>
                <p style="font-size: 14px; color: var(--text-secondary);">{{ __('Start your first timer above to begin tracking your time!') }}</p>
            </div>
        @endforelse
    </div>

    @if($recentEntries->count() > 5)
        <div style="padding: 20px 32px; border-top: 1px solid var(--border);">
            <div class="text-center">
                <a href="{{ route('time-entries.index') }}" class="inline-flex items-center gap-2" style="font-size: 15px; font-weight: 600; color: var(--text); text-decoration: none;">
                    <span>{{ __('View all :count entries', ['count' => $recentEntries->count()]) }}</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    @endif
</div>
