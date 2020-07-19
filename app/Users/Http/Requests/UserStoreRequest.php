<?php

namespace App\Users\Http\Requests;

use App\Users\Models\User;
use Base\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Get the model this validates against
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Determine if the user is authorized to make this request.
     * @todo: If user has admin or allowed_role
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
