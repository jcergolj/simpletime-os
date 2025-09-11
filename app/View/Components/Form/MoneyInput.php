<?php

namespace App\View\Components\Form;

use App\Enums\Currency;
use App\Models\Client;
use App\Models\Project;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MoneyInput extends Component
{
    public string $defaultCurrency;

    public string $defaultValue;

    public function __construct(
        public ?string $value = null,
        public Currency|string|null $currency = null,
        public bool $required = false,
        public ?string $id = null,
        public bool $useCommonCurrencies = true,
        public ?Project $project = null,
        public ?Client $client = null,
        public ?string $currencyAttributes = null
    ) {
        $this->defaultValue = $this->determineAmount();
        $this->value ??= $this->defaultValue;
        $this->defaultCurrency = $this->determineCurrency();
        $this->id ??= 'hourly_rate_amount';
    }

    protected function determineCurrency(): string
    {
        $oldValue = old('hourly_rate_currency');
        if ($oldValue !== null) {
            return (string) $oldValue;
        }

        if (! in_array($this->currency, [null, '', '0'], true)) {
            return $this->currency instanceof Currency ? $this->currency->value : $this->currency;
        }

        if ($this->project?->hourlyRate?->rate) {
            return $this->project->hourlyRate->rate->currency->value;
        }

        if ($this->client?->hourlyRate?->rate) {
            return $this->client->hourlyRate->rate->currency->value;
        }

        if ($this->project?->client?->hourlyRate?->rate) {
            return $this->project->client->hourlyRate->rate->currency->value;
        }

        if (auth()->check() && auth()->user()->hourlyRate) {
            return auth()->user()->hourlyRate->rate->currency->value;
        }

        return Currency::USD->value;
    }

    protected function determineAmount(): string
    {
        if (old('hourly_rate_amount') !== null) {
            return old('hourly_rate_amount');
        }

        if ($this->value !== null) {
            return $this->value;
        }

        if ($this->project?->hourlyRate?->rate) {
            return (string) $this->project->hourlyRate->rate->toDecimal();
        }

        if ($this->client?->hourlyRate?->rate) {
            return (string) $this->client->hourlyRate->rate->toDecimal();
        }

        if ($this->project?->client?->hourlyRate?->rate) {
            return (string) $this->project->client->hourlyRate->rate->toDecimal();
        }

        if (auth()->check() && auth()->user()->hourlyRate) {
            return (string) auth()->user()->hourlyRate->rate->toDecimal();
        }

        return '';
    }

    public function currencyOptions(): array
    {
        return $this->useCommonCurrencies
            ? Currency::commonOptions()
            : Currency::options();
    }

    public function render(): View|Closure|string
    {
        return view('components.form.money-input');
    }
}
