<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends AppFormRequest
{
    protected function getRedirectUrl(): string
    {
        return route('projects.edit', $this->route('project'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'client_id' => ['required', 'exists:clients,id'],
            'hourly_rate_amount' => ['nullable', 'numeric', 'min:0'],
            'hourly_rate_currency' => ['required_with:hourly_rate_amount', 'string', Rule::enum(Currency::class)],
            'update_existing_entries' => ['nullable', 'boolean'],
        ];
    }
}
