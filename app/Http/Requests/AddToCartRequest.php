<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'fromDate' => 'required|date_format:Y-m-d H:i',
            'toDate' => 'required|date_format:Y-m-d H:i|after:from',
            'itemId' => 'required|exists:items,id',
        ];
    }
}
