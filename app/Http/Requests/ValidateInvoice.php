<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateInvoice extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required',
            'invoice_number' => 'required',
            'due_date' => 'required',
            'payment_term' => 'required',
            'currency' => 'required',
            'type' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'customer_id.required' => 'The Customer ID is required.',
            'invoice_number.required' => 'The invoice number is required.',
            'due_date.required' => 'The Due date is required.',
            'currency.required' => 'The Currency is required.',
            'type.required' => 'The Type is required.',
            'items.required' => 'The Items field is required.',
            'items.*.amount.required' => 'The Amount field is required.',
            'items.*.amount.numeric' => 'The Amount field must be a number.',
            'items.*.description.string' => 'The Description field must be a string.',
        ];
    }

}

