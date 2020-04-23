<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Spatie\UrlSigner\MD5UrlSigner;
use App\User;

class Verify extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = rtrim(Config::get('app.url'), '/') . '/auth/verify/' . $this->user->id;

        $signer = new MD5UrlSigner(Config::get('app.url_sign_secret'));

        $verifyUrl = $signer->sign($url, 10);

        return $this->view('emails.auth.verify')
            ->with([
                'name' => $this->user->name,
                'verifyUrl' => $verifyUrl
            ]);
    }
}
