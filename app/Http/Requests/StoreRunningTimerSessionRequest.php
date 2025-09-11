<?php

namespace App\Http\Requests;

class StoreRunningTimerSessionRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            'client_id' => ['nullable', 'exists:clients,id'],
            'project_id' => ['nullable', 'exists:projects,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.exists' => __('The selected client is invalid.'),
            'project_id.exists' => __('The selected project is invalid.'),
        ];
    }
}
