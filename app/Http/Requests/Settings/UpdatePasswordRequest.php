<?php

namespace App\Http\Requests\Settings;

use App\Http\Requests\AppFormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends AppFormRequest
{
    protected function getRedirectUrl(): string
    {
        return url()->previous() ?: route('settings.password.edit');
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ];
    }
}
