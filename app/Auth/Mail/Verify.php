<?php

namespace App\Auth\Mail;

use App\Users\User;
use Datetime;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Spatie\UrlSigner\MD5UrlSigner;

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
     * Build a signed url for verifications
     *
     * @param  string   $type
     * @param  Datetime $expiration
     * @return string
     */
    public function buildVerifyUrl(string $type, Datetime $expiration)
    {
        $url =  rtrim(Config::get('app.url'), '/').
                '/verify/'.
                $type.
                '/'.
                $this->user->id;

        $signer = new MD5UrlSigner(Config::get('app.url_sign_secret'));

        return $signer->sign($url, $expiration);
    }
}
