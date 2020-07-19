<?php

namespace App\Users\Rules;

use Illuminate\Contracts\Validation\Rule;

class Username implements Rule
{
    protected $min = 5;

    protected $max = 24;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $length = strlen($value);

        $pattern = '/^[a-z\d_]*$/i';

        return
            $length >= $this->min &&
            $length <= $this->max &&
            preg_match($pattern, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Username must contain only letters, numbers and underscores between '.$this->min.' and '.$this->max.' characters';
    }
}
