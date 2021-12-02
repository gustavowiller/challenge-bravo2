<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\FormRequest;

class PostCurrency extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "code" => "required|alpha|max:5"
        ];
    }
}
