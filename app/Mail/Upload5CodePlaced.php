<?php

namespace App\Mail;

use App\Model\Ord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Upload5CodePlaced extends Mailable
{
    use Queueable, SerializesModels;


    public $ord;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ord $ord)
    {
        $this->ord = $ord;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->bcc(setting('email_contact'),env('MAIL_FROM_NAME'))
                    ->bcc('eric@suneasy-tw.com', 'Eric')
                    ->subject('匯款帳號後5碼回報通知')
                    ->markdown('emails.upload5code.placed');
    }
}
