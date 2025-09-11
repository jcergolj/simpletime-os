<turbo-stream action="replace" target="recent-entry-{{ $timeEntry->id }}">
    <template>
        <x-recent-time-entry :entry="$timeEntry" :running-timer="$runningTimer" />
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

<turbo-stream action="replace" target="timer-widget">
    <template>
        <x-timer-widget
            :last-entry="$timeEntry"
            :running-timer="$runningTimer"
        />
    </template>
</turbo-stream>
