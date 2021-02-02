<?php

namespace App\Mail;

use App\Exports\UserExport;
use App\Model\Cate;
use App\Model\Contact;
use App\Model\frontend\User;
use App\Model\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SendUserDataAndCateNotifyPlaced extends Mailable
{
    use Queueable, SerializesModels;


    public $user;
    public $subscriber;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Subscriber $subscriber, $email)
    {
        $this->user = $user;
        $this->subscriber = $subscriber;
        $this->email = $email;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $file_name=date('YmdHis').'_'.$this->user->name.'_'.$this->user->idno.'.xlsx';
        return $this->to($this->email, env('MAIL_FROM_NAME'))
                    ->subject('會員資料及需求單審核通知')
                    ->markdown('emails.subscriber.send_user_data_and_cate_placed')
                    ->attach(
                        Excel::download(
                            new UserExport($this->user), $file_name
                        )->getFile(), ['as' => $file_name]
                    );
    }
}
