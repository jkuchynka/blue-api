<?php

namespace App\Auth\Mail;

use Datetime;

class ResetPassword extends Verify
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $auth = resolve('modules')->getModule('auth');

        $expiration = (new Datetime)->modify($auth['verify_expiration.reset_password']);
        $verifyUrl = $this->buildVerifyUrl('reset-password', $expiration);

        return $this->view('Auth::reset-password')
            ->with([
                'verifyUrl' => $verifyUrl,
                'user' => $this->user
            ]);
    }
}
