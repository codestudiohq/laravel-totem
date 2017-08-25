<?php

namespace Studio\Totem\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskCompleted extends Notification
{
    use Queueable;

    /**
     * @var
     */
    private $output;

    /**
     * Create a new notification instance.
     */
    public function __construct($output)
    {
        $this->output = $output;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->notification_email_address ? ['mail'] : [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->introLines('Hi,')
                    ->line("We just finished executing your task. Here's the result")
                    ->line($this->output)
                    ->line('Your Truly,')
                    ->line('Laravel Totem');
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
