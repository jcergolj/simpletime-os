@props([
    'title',
    'items',
    'singularLabel',
    'pluralLabel',
])

<div class="px-8 py-7 border-b border-[var(--border)]">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <h3 class="list-header-title">{{ $title }}</h3>
            <p class="list-header-subtitle">{{ $items->total() }} {{ Str::plural($singularLabel, $items->total()) }} {{ __('total') }}</p>
        </div>
        @if($items->hasPages())
            <div class="list-header-subtitle">
                {{ __('Showing') }} {{ $items->firstItem() }}-{{ $items->lastItem() }} {{ __('of') }} {{ $items->total() }}
            </div>
        @endif
    </div>
</div>
