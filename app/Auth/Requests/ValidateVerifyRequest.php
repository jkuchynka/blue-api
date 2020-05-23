<?php

namespace App\Auth\Requests;

use Base\Rules\SignedUrl;
use Illuminate\Foundation\Http\FormRequest;

class ValidateVerifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => ['required', new SignedUrl]
        ];
    }
}
