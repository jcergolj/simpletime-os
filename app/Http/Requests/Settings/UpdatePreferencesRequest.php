<?php

namespace App\Http\Requests\Settings;

use App\Enums\Currency;
use App\Enums\DateFormat;
use App\Enums\TimeFormat;
use App\Http\Requests\AppFormRequest;
use Illuminate\Validation\Rule;

class UpdatePreferencesRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'date_format' => ['required', 'string', Rule::enum(DateFormat::class)],
            'time_format' => ['required', 'string', Rule::enum(TimeFormat::class)],
            'hourly_rate.amount' => ['nullable', 'numeric', 'min:0'],
            'hourly_rate.currency' => ['required_with:hourly_rate.amount', 'string', Rule::enum(Currency::class)],
        ];
    }
}
