<div class="grid grid-cols-2 gap-3 w-full">
    <div>
        <input
            type="number"
            id="{{ $id }}"
            name="hourly_rate_amount"
            value="{{ $value }}"
            placeholder="0.00"
            class="input-field @error('hourly_rate_amount') border-red-500 @enderror"
            style="width: 100%; font-size: 15px;"
            step="0.01"
            min="0"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => '']) }}
        />
    </div>
    <select
        name="hourly_rate_currency"
        class="input-field @error('hourly_rate_currency') border-red-500 @enderror"
        style="width: 100%; font-size: 15px;"
        {!! $currencyAttributes !!}
    >
        @foreach($currencyOptions() as $code => $display)
            <option value="{{ $code }}" {{ $defaultCurrency === $code ? 'selected' : '' }}>
                {{ $display }}
            </option>
        @endforeach
    </select>
</div>
