<?php

namespace App\Notifications;

use App\Model\admin\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminRegisteredSuccessfully extends Notification
{
    use Queueable;

    /**
     * @var Admin
     */
    protected $admin;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        /** @var Admin $admin */
        $admin = $this->admin;
        return (new MailMessage)
            ->from(env('MAIL_FROM_ADDRESS'))
            ->subject('成功註冊新後台試用帳號啟用通知')
            ->greeting(sprintf('您好：%s', $admin->name))
            ->line('您已成功註冊 '.setting('store_name').' 後台試用帳號. 請點選以下連結，啟用您的帳號.')
            ->action('啟用帳號', route('activate.admin', $admin->activation_code))
            ->line('感謝您的加入!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
