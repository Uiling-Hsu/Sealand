<?php

namespace App\Mail;

use App\Model\frontend\User;
use App\Model\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserSubscriberReviewRejectNotifyPlaced extends Mailable
{
    use Queueable, SerializesModels;


    public $subscriber;
    public $email;
    public $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber,$email,$name)
    {
        $this->subscriber = $subscriber;
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
                    ->subject('會員無法訂閱方案通知')
                    ->markdown('emails.user.user_subscriber_review_reject_notify_place');
    }
}
