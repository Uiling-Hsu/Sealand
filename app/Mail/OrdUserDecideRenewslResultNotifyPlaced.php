<?php

namespace App\Mail;

use App\Model\Ord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrdUserDecideRenewslResultNotifyPlaced extends Mailable
{
    use Queueable, SerializesModels;


    public $ord;
    public $email;
    public $name;
    public $is_ord_renewal;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ord $ord, $email, $name, $is_ord_renewal)
    {
        $this->ord = $ord;
        $this->email = $email;
        $this->name = $name;
        $this->is_ord_renewal = $is_ord_renewal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user=$this->ord->user;
        $partner=$this->ord->partner;
        if($this->is_ord_renewal==1)
            return $this->to($this->email, $this->name)
                ->subject($partner->title.'/'.$this->ord->plate_no.'/'.$user->name.' 會員決定要原車續約通知')
                ->markdown('emails.ords.ord_user_decide_continue_renewal_placed');
                /*->bcc('eric@suneasy-tw.com', 'Eric')*/
        else
            return $this->to($this->email, $this->name)
                ->subject($partner->title.'/'.$this->ord->plate_no.'/'.$user->name.' 會員已決定不續約車輛通知')
                ->markdown('emails.ords.ord_user_decide_not_renewal_placed');
    }
}
