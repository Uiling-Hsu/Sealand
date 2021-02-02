<?php

namespace App\Mail\SendMail;

use App\Exports\UserExport;
use App\Model\Contact;
use App\Model\frontend\User;
use App\Model\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SendSubscriberEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $subscriber;
    public $email;
    public $name;
    public $subject;
    public $view_name;
    public $platform;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber, $email, $name, $subject, $view_name)
    {
        $this->subscriber = $subscriber;
        $this->email = $email;
        $this->name = $name;
        $this->subject = $subject;
        $this->view_name = $view_name;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->email, $this->name)
                    ->subject($this->subject)
                    ->markdown('emails.placed.'. $this->view_name);

    }
}
