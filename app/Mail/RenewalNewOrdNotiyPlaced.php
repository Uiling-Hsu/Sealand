<?php

namespace App\Mail;

use App\Model\Ord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RenewalNewOrdNotiyPlaced extends Mailable
{
    use Queueable, SerializesModels;


    public $ord;
    public $email;
    public $name;
    public $backend;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ord $ord, $email, $name, $backend)
    {
        $this->ord = $ord;
        $this->email = $email;
        $this->name = $name;
        $this->backend = $backend;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->backend==0)
            return $this->to($this->email, $this->name)
                ->subject('車輛續約產生新訂單通知')
                ->markdown('emails.ords.renewal_new_ord_notify_placed');
        else
            return $this->to($this->email, $this->name)
                ->subject('車輛續約產生新訂單通知')
                ->markdown('emails.ords.backend_renewal_new_ord_notify_placed');
    }
}
