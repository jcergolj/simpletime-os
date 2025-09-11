<?php

namespace App\View\Components\Form;

use App\Enums\Currency;
use App\Models\Client;
use App\Models\Project;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HourlyRate extends Component
{
    public function __construct(
        public ?Project $project = null,
        public ?Client $client = null,
    ) {}

    protected function determineCurrency(): string
    {
        $oldValue = old('hourly_rate.currency');
        if ($oldValue !== null) {
            return (string) $oldValue;
        }

        if ($this->project?->hourlyRate) {
            return $this->project->hourlyRate->currency->value;
        }

        if ($this->client?->hourlyRate) {
            return $this->client->hourlyRate->currency->value;
        }

        if ($this->project?->client?->hourlyRate) {
            return $this->project->client->hourlyRate->currency->value;
        }

        if (auth()->check() && auth()->user()->hourlyRate) {
            return auth()->user()->hourlyRate->currency->value;
        }

        return Currency::USD->value;
    }

    protected function determineAmount(): string
    {
        if (old('hourly_rate.amount') !== null) {
            return old('hourly_rate.amount');
        }

        if ($this->project?->hourlyRate) {
            return (string) $this->project->hourlyRate->toDecimal();
        }

        if ($this->client?->hourlyRate) {
            return (string) $this->client->hourlyRate->toDecimal();
        }

        if ($this->project?->client?->hourlyRate) {
            return (string) $this->project->client->hourlyRate->toDecimal();
        }

        if (auth()->check() && auth()->user()->hourlyRate) {
            return (string) auth()->user()->hourlyRate->toDecimal();
        }

        return '';
    }

    public function currencyOptions(): array
    {
        return Currency::options();
    }

    public function render(): View|Closure|string
    {
        return view('components.form.hourly-rate', [
            'amount' => $this->determineAmount(),
            'currency' => $this->determineCurrency(),
        ]);
    }
}
