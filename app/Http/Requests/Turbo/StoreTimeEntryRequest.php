<?php

namespace App\Http\Requests\Turbo;

use App\Enums\Currency;
use App\Http\Requests\AppFormRequest;
use Illuminate\Validation\Rule;

class StoreTimeEntryRequest extends AppFormRequest
{
    protected function getRedirectUrl(): string
    {
        return route('turbo.time-entries.create');
    }

    public function rules(): array
    {
        return [
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'duration' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'hourly_rate_amount' => ['nullable', 'numeric', 'min:0'],
            'hourly_rate_currency' => ['required_with:hourly_rate_amount', 'string', Rule::enum(Currency::class)],
        ];
    }
}
