@props([
    'icon',
    'title',
    'description',
    'actionRoute',
    'actionText',
    'turboFrame' => null,
])

<div class="empty-state">
    <div class="empty-state-icon-wrapper">
        {{ $icon }}
    </div>
    <h3 class="empty-state-title">{{ $title }}</h3>
    <p class="empty-state-description">{{ $description }}</p>
    <a href="{{ $actionRoute }}"
       class="empty-state-action"
       @if($turboFrame) data-turbo-frame="{{ $turboFrame }}" @endif>
        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        <span class="leading-none">{{ $actionText }}</span>
    </a>
</div>
