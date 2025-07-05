<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SelectItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'fromDateTime' => 'required|date_format:Y-m-d H:i',
            'toDateTime' => 'required|date_format:Y-m-d H:i|after:from',
            'itemId' => 'required|exists:items,id',
        ];
    }
}
