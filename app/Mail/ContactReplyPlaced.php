<?php

namespace App\Mail;

use App\Model\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactReplyPlaced extends Mailable
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
                    ->subject(setting('store_name').' 回覆您的留言訊息')
                    ->markdown('emails.contact.reply_placed');
    }
}
