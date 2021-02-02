<?php

namespace App\Mail;

use App\Model\Ord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrdUserCarNotContinueRenewalNotifyPlaced extends Mailable
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
        return $this->to($this->email, $this->name)
                ->subject('車源商不提供車輛續約服務通知')
                ->markdown('emails.ords.ord_user_car_not_continue_renewal_notify_placed');
                /*->bcc('eric@suneasy-tw.com', 'Eric')*/
    }
}
