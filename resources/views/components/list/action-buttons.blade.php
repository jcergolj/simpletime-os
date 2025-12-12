@props([
    'editRoute',
    'deleteRoute',
    'confirmMessage',
    'showEdit' => true,
])

<div class="flex items-center gap-2">
    @if($showEdit)
        <a href="{{ $editRoute }}" style="padding: 8px 16px; background: var(--accent); color: white; border-radius: 8px; font-size: 14px; font-weight: 500; line-height: 1; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; border: none;">
            <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <span style="line-height: 1;">{{ __('Edit') }}</span>
        </a>
    @endif

    <a href="{{ $deleteRoute }}"
       style="padding: 8px 16px; background: white; color: var(--text); border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; font-weight: 500; line-height: 1; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;"
       data-turbo-method="delete"
       data-turbo-confirm="{{ $confirmMessage }}"
       data-turbo-frame="_top">
        <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
        </svg>
        <span style="line-height: 1;">{{ __('Delete') }}</span>
    </a>
</div>
