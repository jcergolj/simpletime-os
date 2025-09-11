@props(['metrics'])

<div id="weekly-earnings" class="card p-5">
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
            <div class="mt-4 pt-4 border-t border-[var(--border)]">
                <div class="flex justify-end">
                    <div class="text-xs text-[var(--text-muted)]">
                        {{ __('Total (combined)') }}: <span class="font-medium">{{ number_format($metrics->totalAmount / 100, 2) }}</span>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="stat-value stat-value-accent">{{ number_format($metrics->totalAmount / 100, 2) }}</div>
    @endif
</div>
