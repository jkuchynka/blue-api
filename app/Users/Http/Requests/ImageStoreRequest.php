<?php

namespace App\Users\Http\Requests;

use Base\Http\FormRequest;

class ImageStoreRequest extends FormRequest
{
    /**
     * Authorize if user is authed and storing for their own account.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->route('user');
        return \Auth::check() && \Auth::id() === $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'required|image'
        ];
    }
}
