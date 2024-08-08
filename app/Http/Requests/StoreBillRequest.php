<?php

namespace App\Http\Requests;

use App\Enums\BillStatusEnum;
use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBillRequest extends FormRequest
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
            'status' => [
                'required',
                Rule::in(BillStatusEnum::getArrayView()),
            ],
            'total' => [
                'required',
            ],
            'note' => [
                'string',
            ],
            'customer_id' => [
                'required',
                Rule::exists(Customer::class, 'id')
            ],
        ];
    }
}
