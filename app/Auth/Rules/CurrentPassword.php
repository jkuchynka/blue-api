<?php

namespace App\Auth\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CurrentPassword implements Rule
{
    protected $failedRequired = false;

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
        $value = (string) $value;
        if (empty($value)) {
            $this->failedRequired = true;
            return false;
        }
        $user = Auth::user();
        return Hash::check($value, $user->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->failedRequired) {
            return 'Current password is required.';
        }
        return 'Invalid password.';
    }
}
