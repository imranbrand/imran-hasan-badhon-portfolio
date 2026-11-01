<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:80'],
            'email'   => ['required', 'email:rfc', 'max:120'],
            'type'    => ['required', Rule::in(array_keys(config('portfolio.contact_types')))],
            'message' => ['required', 'string', 'min:20', 'max:3000'],
            // Honeypot: real visitors never see or fill this field.
            'website' => ['nullable', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'message.min' => 'Please write at least 20 characters so I can understand your request.',
            'type.in'     => 'Choose one of the options.',
        ];
    }
}
