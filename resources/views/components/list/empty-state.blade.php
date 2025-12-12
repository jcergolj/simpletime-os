@props([
    'icon',
    'title',
    'description',
    'actionRoute',
    'actionText',
    'turboFrame' => null,
])

<div style="padding: 64px 32px; text-align: center;">
    <div style="width: 64px; height: 64px; margin: 0 auto 16px; background: var(--bg); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
        {{ $icon }}
    </div>
    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px; color: var(--text);">{{ $title }}</h3>
    <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 20px;">{{ $description }}</p>
    <a href="{{ $actionRoute }}"
       style="padding: 12px 24px; background: var(--accent); color: white; border-radius: 8px; font-size: 15px; font-weight: 500; line-height: 1; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; border: none;"
       @if($turboFrame) data-turbo-frame="{{ $turboFrame }}" @endif>
        <svg style="width: 18px; height: 18px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        <span style="line-height: 1;">{{ $actionText }}</span>
    </a>
</div>
