<?php

namespace App\Mail;

use App\Model\Ord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrdChangeSubdateNotifyPlaced extends Mailable
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
            ->subject($partner->title.'/'.$this->ord->plate_no.'/'.$user->name.'/交車時間變更通知')
            ->markdown('emails.ords.backend_change_subdate_notify_placed');

    }
}
