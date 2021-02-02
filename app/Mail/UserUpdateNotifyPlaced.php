<?php

namespace App\Mail;

use App\Model\Contact;
use App\Model\frontend\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserUpdateNotifyPlaced extends Mailable
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
    public function __construct(User $user, $email, $name)
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
                    ->subject('已收到會員資料上傳及更新完成通知')
                    ->markdown('emails.user.user_update_notify_placed');
    }
}
