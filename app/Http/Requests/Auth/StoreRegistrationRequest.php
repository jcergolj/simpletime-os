<?php

namespace App\Http\Requests\Auth;

use App\Enums\Currency;
use App\Http\Requests\AppFormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreRegistrationRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'hourly_rate.amount' => ['nullable', 'numeric', 'min:0'],
            'hourly_rate.currency' => ['required_with:hourly_rate.amount', 'string', Rule::enum(Currency::class)],
        ];
    }
}
