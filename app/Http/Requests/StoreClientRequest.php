<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use Illuminate\Validation\Rule;

class StoreClientRequest extends AppFormRequest
{
    protected function getRedirectUrl(): string
    {
        return route('clients.create');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'hourly_rate_amount' => ['nullable', 'numeric', 'min:0'],
            'hourly_rate_currency' => ['required_with:hourly_rate_amount', 'string', Rule::enum(Currency::class)],
        ];
    }
}
