<?php

namespace App\Auth\Requests;

use App\Auth\Rules\CurrentPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $request = new ResetPasswordRequest;
        $rules = Arr::only($request->rules(), ['password', 'password_confirm']);
        $rules['current_password'] = [new CurrentPassword];
        return $rules;
    }
}
