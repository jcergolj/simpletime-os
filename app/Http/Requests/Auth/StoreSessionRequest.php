<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AppFormRequest;

class StoreSessionRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
