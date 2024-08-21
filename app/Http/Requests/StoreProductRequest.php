<?php

namespace App\Http\Requests;

use App\Models\Manufacturer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            ],
            'description' => [
                'required',
            ],
            'price' => [
                'required',
            ],
            'image' => [
                'required',
            ],
            'more_images' => [
                'required',
            ],
            'manufacturer_id' => [
                'required',
                Rule::exists(Manufacturer::class, 'id'),
            ],
        ];
    }
}
