<?php

namespace App\Http\Requests;

use App\Models\Constants\PaymentMethods;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:255',
            'billing_name' => 'required|string|max:255',
            'billing_vat_number' => 'nullable|string|max:255',
            'billing_address' => 'required|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_county' => 'required|string|max:255',
            'billing_country' => 'required|string|max:255',
            'payment_method' => [
                'required',
                'string',
                Rule::in(PaymentMethods::CASH, PaymentMethods::CARD, PaymentMethods::BANK_TRANSFER),
            ],
        ];
    }
}
