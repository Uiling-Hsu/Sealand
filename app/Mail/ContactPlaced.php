<?php

namespace App\Mail;

use App\Model\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactPlaced extends Mailable
{
    use Queueable, SerializesModels;


    public $contact;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->contact->email, $this->contact->name)
                    ->bcc(setting('email_contact'),env('MAIL_FROM_NAME'))
                    ->bcc('eric@suneasy-tw.com', env('MAIL_FROM_NAME'))
                    ->subject('已收到您的訊息通知')
                    ->markdown('emails.contact.placed');
    }
}
