@props(['href', 'turboFrame' => null])

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 rounded-lg border border-transparent hover:border-base-300 transition-colors font-medium text-base-content/70 hover:text-base-content']) }}
    @if($turboFrame) data-turbo-frame="{{ $turboFrame }}" @endif
>
    {{ $slot }}
</a>
