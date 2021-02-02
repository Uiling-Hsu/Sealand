<?php

namespace App\Mail\SendMail;

use App\Model\Ord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOrdEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $ord;
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
    public function __construct(Ord $ord, $email, $name, $subject, $view_name)
    {
        $this->ord = $ord;
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
