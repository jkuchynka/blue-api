<?php

namespace App\Auth\Requests;

use Base\Rules\SignedUrl;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    protected $signedUrl;

    public function __construct()
    {
        $this->signedUrl = new SignedUrl;
    }

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
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password',
            'url' => ['required', $this->signedUrl]
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated()
    {
        $validated = parent::validated();
        $validated['user'] = $this->signedUrl->user;
        return $validated;
    }
}
