<?php

namespace App\Mail\SendMail;

use App\Exports\Combine3Export;
use App\Model\Ord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class SendOrdPlaceEmail extends Mailable
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
        $file_name = 'Info_'.$this->ord->ord_no.'.xlsx';
        return $this->to($this->email, $this->name)
            ->subject($this->subject)
            ->markdown('emails.placed.'. $this->view_name)
            ->attach(
                Excel::download(
                    new Combine3Export($this->ord), $file_name
                )->getFile(), [ 'as' => $file_name ]
            );
    }
}
