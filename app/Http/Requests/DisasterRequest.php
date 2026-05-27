<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisasterRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()?->isAdmin() ?? false; }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'min:3', 'max:150'],
            'type'         => ['required', 'in:flood,earthquake,cyclone,fire,landslide,pandemic'],
            'severity'     => ['required', 'in:low,medium,high,critical'],
            'description'  => ['required', 'string', 'min:50'],
            'what_to_do'   => ['required', 'string', 'min:30'],
            'what_not_to_do' => ['required', 'string', 'min:30'],
            'region'       => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'description.min'    => 'Description must be at least 50 characters.',
            'what_to_do.min'     => 'Please provide at least 30 characters of advice.',
            'what_not_to_do.min' => 'Please provide at least 30 characters of warnings.',
        ];
    }
}
