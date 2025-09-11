<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'client_id' => ['required', 'exists:clients,id'],
            'hourly_rate.amount' => ['nullable', 'numeric', 'min:0'],
            'hourly_rate.currency' => ['required_with:hourly_rate.amount', 'string', Rule::enum(Currency::class)],
            'update_existing_entries' => ['nullable', 'boolean'],
        ];
    }
}
