<?php

namespace Base\Rules;

use App\Users\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Config;
use Spatie\UrlSigner\MD5UrlSigner;

class SignedUrl implements Rule
{
    public $user;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $signer = new MD5UrlSigner(Config::get('app.url_sign_secret'));
        $valid = $signer->validate($value);

        $parts = explode('/', parse_url($value, PHP_URL_PATH));
        $userId = array_pop($parts);
        $this->user = User::find($userId);

        return $valid && $this->user;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The url is expired or invalid.';
    }
}
