<?php

namespace App\Mail;

use App\Model\Ord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrdPartnerRenewalSettingNotifyPlaced extends Mailable
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
        $user=$this->ord->user;
        $partner=$this->ord->partner;
        return $this->to($this->email, $this->name)
                ->subject($partner->title.'/'.$this->ord->plate_no.'/'.$user->name.' 車輛 是否提供續約 設定通知')
                ->markdown('emails.ords.ord_partner_renewal_setting_placed');
                /*->bcc('eric@suneasy-tw.com', 'Eric')*/
    }
}
