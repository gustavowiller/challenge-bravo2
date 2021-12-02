<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\FormRequest;

class ConvertRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from' => 'required|alpha|max:5|exists:App\Models\Currency,code',
            'to' => 'required|alpha|max:5|exists:App\Models\Currency,code',
            'amount' => 'required|numeric|min:0'
        ];
    }
}
