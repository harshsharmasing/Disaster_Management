<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChecklistRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'min:3', 'max:100'],
            'disaster_type' => ['required', 'in:flood,earthquake,cyclone,fire,landslide,pandemic'],
        ];
    }
}
