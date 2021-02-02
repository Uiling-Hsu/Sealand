<?php

namespace App\Mail;

use App\Model\Ord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrdPartnerRremindDeliveryCarNotifyPlaced extends Mailable
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
        $partner=$this->ord->partner;
        $user=$this->ord->user;
        $plate_no=$this->ord->plate_no;
        if(!$plate_no)
            $plate_no=$this->ord->model;
        return $this->to($this->email, $this->name)
                ->subject($partner->title.'/'.$plate_no.'/'.$user->name.' 交車提醒')
                ->markdown('emails.ords.ord_partner_remind_delivery_car_notify_placed');
                /*->bcc('eric@suneasy-tw.com', 'Eric')*/
    }
}
