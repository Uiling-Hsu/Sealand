<?php

namespace App\Mail;

use App\Exports\Combine3Export;
use App\Exports\OrdExport;
use App\Exports\ProductExport;
use App\Exports\UserExport;
use App\Model\Ord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Facades\Excel;

class OrdCancelPlaced extends Mailable
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
        $partner=$this->ord->partner;
        if($this->is_backend==1) {
            $user=$this->ord->user;
            return $this->to($this->email, $this->name)
                ->subject($partner->title.'/'.$this->ord->plate_no.'/'.$user->name.' 訂單已取消')
                ->markdown('emails.ords.backend_ord_cancel_placed');
        }
        else
            return $this->to($this->email, $this->name)
                ->subject(' 訂單已取消通知')
                ->markdown('emails.ords.ord_cancel_placed');
    }
}
