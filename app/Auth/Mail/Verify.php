<?php

namespace App\Auth\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Spatie\UrlSigner\MD5UrlSigner;
use App\Users\User;

class Verify extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $type = 'verify';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = rtrim(Config::get('app.url'), '/') . '/verify/' . $this->type . '/' . $this->user->id;

        $signer = new MD5UrlSigner(Config::get('app.url_sign_secret'));

        $verifyUrl = $signer->sign($url, 10);

        return $this->view('emails.auth.' . $this->type)
            ->with([
                'verifyUrl' => $verifyUrl,
                'user' => $this->user
            ]);
    }
}
