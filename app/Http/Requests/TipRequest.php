<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Rule;

class TipRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'min:5', 'max:150', new \App\Rules\NoAllCaps],
            'body'          => ['required', 'string', 'min:30', 'max:3000'],
            'disaster_type' => ['required', 'in:flood,earthquake,cyclone,fire,landslide,pandemic,general'],
            'region'        => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'body.min' => 'Please write at least 30 characters — share your experience in detail.',
        ];
    }
}
