@props(['type' => 'submit', 'icon' => null])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn-primary sm:w-auto', 'style' => 'display: inline-flex; align-items: center; justify-content: center; gap: 6px; line-height: 1;']) }}>
    @if($icon)
        {!! $icon !!}
    @endif
    <span style="line-height: 1;">{{ $slot }}</span>
</button>
