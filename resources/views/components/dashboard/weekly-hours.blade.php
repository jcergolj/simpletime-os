@props(['metrics'])

<div id="weekly-hours" class="card" style="padding: 32px;">
    <div class="stat-label">{{ __('Total Hours This Week') }}</div>
    <div class="stat-value">{{ number_format($metrics->totalHours, 1) }}h</div>
</div>
