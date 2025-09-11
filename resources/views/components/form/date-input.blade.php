<div>
    <input
        type="date"
        name="date"
        value="{{ old('date', $value) }}"
        placeholder="Select date"
        {{ $attributes->merge(['class' => $inputClasses()]) }}
    />
    @if($userFormat())
        <p class="mt-1 text-xs text-gray-500">{{ __('Format: :format', ['format' => $formatExample()]) }}</p>
    @endif
</div>