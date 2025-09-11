<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use Illuminate\Validation\Rule;

class StoreClientRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'hourly_rate.amount' => ['nullable', 'numeric', 'min:0'],
            'hourly_rate.currency' => ['required_with:hourly_rate.amount', 'string', Rule::enum(Currency::class)],
        ];
    }
}
