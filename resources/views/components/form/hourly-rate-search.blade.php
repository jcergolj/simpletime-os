<div class="grid grid-cols-2 gap-3 w-full">
    <div>
        <input
            type="number"
            name="hourly_rate[amount]"
            value="{{ $amount }}"
            placeholder="0.00"
            class="input-field @error('hourly_rate.amount') border-red-500 @enderror"
            style="width: 100%; font-size: 15px;"
            step="0.01"
            min="0"
            data-search-clients-target="{{ $inputTarget }}"
            data-search-projects-target="{{ $inputTarget }}"
        />
    </div>
    <select
        name="hourly_rate[currency]"
        class="input-field @error('hourly_rate.currency') border-red-500 @enderror"
        style="width: 100%; font-size: 15px;"
        data-search-clients-target="{{ $selectTarget }}"
        data-search-projects-target="{{ $selectTarget }}"
    >
        @foreach($currencyOptions() as $code => $display)
            <option value="{{ $code }}" {{ $currency === $code ? 'selected' : '' }}>
                {{ $display }}
            </option>
        @endforeach
    </select>
</div>
