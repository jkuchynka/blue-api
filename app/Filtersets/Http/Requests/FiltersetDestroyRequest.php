<?php

namespace App\Filtersets\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Laratrust;

class FiltersetDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Laratrust::isAbleTo('save-filtersets');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
