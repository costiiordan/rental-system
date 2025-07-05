<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RemoveSelectedItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|string|max:50',
        ];
    }
}
