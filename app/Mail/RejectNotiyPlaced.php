<?php

namespace App\Mail;

use App\Model\frontend\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RejectNotiyPlaced extends Mailable
{
    use Queueable, SerializesModels;


    public $user;
    public $email;
    public $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$email,$name)
    {
        $this->user = $user;
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
                    ->subject('資料補齊提醒通知')
                    ->markdown('emails.user.user_reject_notify_placed');
    }
}
