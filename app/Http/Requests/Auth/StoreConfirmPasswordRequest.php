<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AppFormRequest;

class StoreConfirmPasswordRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'password' => ['required', 'string'],
        ];
    }
}
