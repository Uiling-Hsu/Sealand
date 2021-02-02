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

class OrdPlaced extends Mailable
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
        if($this->is_backend==1) {
            $file_name = 'Info_'.$this->ord->ord_no.'.xlsx';
            $user=$this->ord->user;
            $partner=$this->ord->partner;
            return $this->to($this->email, $this->name)
                ->subject($partner->title.'/'.$this->ord->plate_no.'/'.$user->name.' 保證金已付款通知')
                ->markdown('emails.ords.backend_placed')
                ->attach(
                    Excel::download(
                        new Combine3Export($this->ord), $file_name
                    )->getFile(), [ 'as' => $file_name ]
                );
        }
        else
            return $this->to($this->email, $this->name)
                ->subject('訂閱 保證金 已付款通知')
                ->markdown('emails.ords.placed');
    }
}
