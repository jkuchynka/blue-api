<?php

namespace App\Users\Http\Requests;

use App\Users\Models\User;
use Base\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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

    public function relations()
    {
        return ['roles', 'permissions'];
    }

    /**
     * Determine if the user is authorized to make this request.
     * @todo: If user has admin, allowed role or user_owned
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
