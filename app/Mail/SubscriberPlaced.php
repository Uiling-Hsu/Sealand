<?php

namespace App\Mail;

use App\Model\Ord;
use App\Model\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscriberPlaced extends Mailable
{
    use Queueable, SerializesModels;


    public $subscriber;
    public $email;
    public $name;
    public $backend;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber, $email, $name, $backend)
    {
        $this->subscriber = $subscriber;
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
        $backend_str='';
        if($this->backend==1)
            $backend_str='backend_';
        return $this->to($this->email, $this->name)
                    ->subject('會員車輛訂閱通知')
                    ->markdown('emails.subscriber.'.$backend_str.'placed');
    }
}
