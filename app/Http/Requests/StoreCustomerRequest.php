<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:50',
                'min:2'
            ],
            'avatar' => [
                'required',
                'file',
                'image',
            ],
            'gender' => [
                'required',
                'boolean',
            ],
            'dob' => [
                'required',
                'date',
            ],
            'email' => [
                'required',
                'email',
                'unique:customers,email'
            ],
            'password' => [
                'required',
                'string',
            ],
            'address' => [
                'required',
            ],
            'phone_number' => [
                'required',
            ],
        ];
    }
    public function messages()
    {
        return [
            'email.unique' => 'The email has already been taken.',
        ];
    }
}
