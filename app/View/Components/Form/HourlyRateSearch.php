<?php

namespace App\View\Components\Form;

use App\Enums\Currency;
use App\ValueObjects\Money;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HourlyRateSearch extends Component
{
    public string $amount;
    public string $currency;

    public function __construct(
        public string $inputTarget,
        public string $selectTarget,
        public ?Money $defaultHourlyRate = null,
    ) {
        $this->amount = $defaultHourlyRate?->toInputValue() ?? '';
        $this->currency = $defaultHourlyRate?->currency->value ?? 'USD';
    }

    public function currencyOptions(): array
    {
        return Currency::options();
    }

    public function render(): View|Closure|string
    {
        return view('components.form.hourly-rate-search');
    }
}
