
<x-layouts.app :title="__('Time Tracking Dashboard')">
    <div class="space-y-8">
        <!-- Header -->
        <div class="px-4 sm:px-0">
            <h1 style="font-size: 48px; font-weight: 700; margin-bottom: 8px; letter-spacing: -0.5px; color: var(--text);">{{ __('Dashboard') }}</h1>
            <p style="font-size: 17px; color: var(--text-secondary); font-weight: 400;">{{ __('Weekly overview and time tracking') }}</p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 px-4 sm:px-0">
            <turbo-frame id="weekly-hours">
                <x-dashboard.weekly-hours />
            </turbo-frame>

            <turbo-frame id="weekly-earnings">
                <x-dashboard.weekly-earnings />
            </turbo-frame>
        </div>

        <!-- Timer Section -->
        <div class="card mx-4 sm:mx-0" style="padding: 40px;">
            @if($runningTimer)
                @include('turbo::timer-sessions.running', ['runningTimer' => $runningTimer])
            @else
                <x-timer-widget :running-timer="$runningTimer" :last-entry="$lastEntry" />
            @endif
        </div>

        <!-- Recent Entries -->
        <div class="px-4 sm:px-0">
            <turbo-frame id="recent-entries">
                @include('dashboard.recent-entries', ['recentEntries' => $recentEntries])
            </turbo-frame>
        </div>
    </div>
</x-layouts.app>
