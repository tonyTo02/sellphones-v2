<?php

namespace App\Http\Requests;

use App\Models\Manufacturer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                'min:6',
                'max:30',
                'string',
            ],
            'address' => [
                'required',
            ],
            'phone_number' => [
                'required',
                'min:10',
                'max:10',
            ],
        ];
    }
    public function messages()
    {
        return [
            'email.unique' => 'The email has already been taken.',
            'manufacturer_id.exists' => 'The Manufacturer is not exists.',
            'phone_number.min' => 'Phone number is invalid.',
            'phone_number.max' => 'Phone number is invalid.',
        ];
    }
}
