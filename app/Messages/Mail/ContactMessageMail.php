<?php

namespace App\Messages\Mail;

use App\Messages\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var ContactMessage
     */
    public $contactMessage;

    /**
     * Create a new message instance.
     *
     * @param ContactMessage $contactMessage
     * @return void
     */
    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'New '.env('APP_NAME').' message: '.$this->contactMessage->subject;
        return $this
            ->subject($subject)
            ->replyTo($this->contactMessage->email, $this->contactMessage->name)
            ->view('Messages::contact-message-mail');
    }
}
