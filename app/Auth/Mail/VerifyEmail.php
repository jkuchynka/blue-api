<?php

namespace App\Auth\Mail;

use Datetime;

class VerifyEmail extends Verify
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $auth = resolve('modules')->getModule('auth');

        $expiration = (new Datetime)->modify($auth['verify_expiration.registration']);
        $verifyUrl = $this->buildVerifyUrl('registration', $expiration);

        return $this->view('Auth::registration')
            ->with([
                'verifyUrl' => $verifyUrl,
                'user' => $this->user
            ]);
    }
}
