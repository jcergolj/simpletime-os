@props(['metrics'])

<div id="weekly-earnings" class="card" style="padding: 32px;">
    <div class="stat-label">{{ __('Weekly Earnings') }}</div>

    @if(count($metrics->weeklyEarnings) > 0)
        <div class="flex flex-wrap gap-2 sm:gap-3">
            @foreach($metrics->weeklyEarnings as $earning)
                <div class="stat-value stat-value-accent">
                    {{ $earning->formatted() }}
                </div>
            @endforeach
        </div>

        @if(count($metrics->weeklyEarnings) > 1)
            <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border);">
                <div class="flex justify-end">
                    <div style="font-size: 12px; color: var(--text-muted);">
                        {{ __('Total (combined)') }}: <span style="font-weight: 500;">{{ number_format($metrics->totalAmount / 100, 2) }}</span>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="stat-value stat-value-accent">{{ number_format($metrics->totalAmount / 100, 2) }}</div>
    @endif
</div>
