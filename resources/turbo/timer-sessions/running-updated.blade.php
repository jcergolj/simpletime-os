<turbo-stream action="replace" target="timer-widget">
    <template>
        @include('turbo::timer-sessions.running', ['runningTimer' => $runningTimer])
    </template>
</turbo-stream>

<turbo-stream action="replace" target="recent-entries">
    <template>
        @include('dashboard.recent-entries', compact('recentEntries'))
    </template>
</turbo-stream>

<turbo-stream action="replace" target="weekly-hours">
    <template>
        <x-dashboard.weekly-hours />
    </template>
</turbo-stream>

<turbo-stream action="replace" target="weekly-earnings">
    <template>
        <x-dashboard.weekly-earnings />
    </template>
</turbo-stream>
