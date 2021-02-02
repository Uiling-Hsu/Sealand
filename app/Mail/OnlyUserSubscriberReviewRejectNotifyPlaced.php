<?php

namespace App\Mail;

use App\Model\frontend\User;
use App\Model\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OnlyUserSubscriberReviewRejectNotifyPlaced extends Mailable
{
    use Queueable, SerializesModels;


    public $subscriber;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user=$this->subscriber->user;
        return $this->to($user->email, $user->name)
                    ->subject('會員無法訂閱方案通知')
                    ->markdown('emails.user.only_user_subscriber_review_reject_notify_place');
    }
}
