<?php

namespace App\Http\Requests\Turbo;

use App\Enums\Currency;
use App\Http\Requests\AppFormRequest;
use Illuminate\Validation\Rule;

class UpdateTimeEntryRequest extends AppFormRequest
{
    protected function getRedirectUrl(): string
    {
        if ($this->boolean('is_recent', false)) {
            return route('dashboard');
        }

        return route('turbo.time-entries.edit', $this->timeEntry);
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

    public function messages(): array
    {
        return [
            'start_time.required' => 'Start time is required.',
            'start_time.date' => 'Start time must be a valid date.',
            'end_time.date' => 'End time must be a valid date.',
            'end_time.after' => 'End time must be after start time.',
            'duration.integer' => 'Duration must be a valid number.',
            'duration.min' => 'Duration must be at least 0.',
            'client_id.exists' => 'Selected client does not exist.',
            'project_id.exists' => 'Selected project does not exist.',
            'hourly_rate_amount.numeric' => 'Hourly rate must be a valid number.',
            'hourly_rate_amount.min' => 'Hourly rate must be at least 0.',
            'hourly_rate_currency.required_with' => 'Currency is required when hourly rate is specified.',
        ];
    }
}
