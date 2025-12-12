@props([
    'title',
    'items',
    'singularLabel',
    'pluralLabel',
])

<div style="padding: 28px 32px; border-bottom: 1px solid var(--border);">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <h3 style="font-size: 28px; font-weight: 600; color: var(--text); margin-bottom: 4px;">{{ $title }}</h3>
            <p style="font-size: 14px; color: var(--text-secondary);">{{ $items->total() }} {{ Str::plural($singularLabel, $items->total()) }} {{ __('total') }}</p>
        </div>
        @if($items->hasPages())
            <div style="font-size: 14px; color: var(--text-secondary);">
                {{ __('Showing') }} {{ $items->firstItem() }}-{{ $items->lastItem() }} {{ __('of') }} {{ $items->total() }}
            </div>
        @endif
    </div>
</div>
