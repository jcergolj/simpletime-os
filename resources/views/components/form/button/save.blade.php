@props(['text' => 'Create'])

<x-form.button.primary type="submit" class="flex items-center gap-1">
    <svg class="h-4 w-4 inline-block align-middle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
    </svg>
    <span class="align-middle">
        {{ $text }}
    </span>
</x-form.button.primary>
