<?php

namespace App\Mail;

use App\Model\Ord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrdPay3NotiyPlaced extends Mailable
{
    use Queueable, SerializesModels;


    public $ord;
    public $email;
    public $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ord $ord, $email, $name)
    {
        $this->ord = $ord;
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject='迄租款 無需繳款通知';
        if($this->ord->payment_backcar_total>0)
            $subject='迄租款 繳款通知';

            return $this->to($this->email, $this->name)
                ->subject($subject)
                ->markdown('emails.ord_pay3_notiy_placed.placed');

    }
}
