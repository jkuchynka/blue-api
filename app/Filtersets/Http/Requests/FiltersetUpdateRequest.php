<?php

namespace App\Filtersets\Http\Requests;

use App\Filtersets\Models\Filterset;
use Base\Http\FormRequest;
use Laratrust;

class FiltersetUpdateRequest extends FormRequest
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
     * Get the model this validates against
     *
     * @return string
     */
    public function model()
    {
        return Filterset::class;
    }

    public function relations()
    {
        return ['filters'];
    }
}
