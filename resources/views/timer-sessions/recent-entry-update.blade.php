<turbo-stream action="replace" target="recent-entry-{{ $timeEntry->id }}">
    <template>
        <x-recent-time-entry :entry="$timeEntry" :running-timer="$runningTimer" />
    </template>
</turbo-stream>

<turbo-stream action="replace" target="weekly-hours">
    <template>
        @include('dashboard.weekly-hours', compact('totalHours'))
    </template>
</turbo-stream>

<turbo-stream action="replace" target="weekly-earnings">
    <template>
        @include('dashboard.weekly-earnings', compact('totalAmount', 'weeklyEarnings'))
    </template>
</turbo-stream>

<turbo-stream action="replace" target="timer-widget">
    <template>
        <x-timer-widget
            :preselected-client-id="$timeEntry->client_id"
            :preselected-client-name="$timeEntry->client?->name"
            :preselected-project-id="$timeEntry->project_id"
            :preselected-project-name="$timeEntry->project?->name"
            :running-timer="$runningTimer"
        />
    </template>
</turbo-stream>
