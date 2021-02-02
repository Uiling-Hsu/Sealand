<?php

namespace App\Mail;

use App\Model\Ord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrdPlaced2 extends Mailable
{
    use Queueable, SerializesModels;


    public $ord;
    public $email;
    public $name;
    public $is_backend;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ord $ord, $email, $name, $is_backend)
    {
        $this->ord = $ord;
        $this->email = $email;
        $this->name = $name;
        $this->is_backend = $is_backend;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $backend='';
        if($this->is_backend==1)
            $backend='backend_';

        return $this->to($this->email, $this->name)
            ->subject('起租款付淸通知')
            ->markdown('emails.ords.'.$backend.'placed2');

    }
}
