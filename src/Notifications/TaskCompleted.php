<?php

namespace Studio\Totem\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class TaskCompleted extends Notification implements ShouldQueue
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
        $channels = [];
        if ($notifiable->notification_email_address) {
            $channels[] = 'mail';
        }
        if ($notifiable->notification_phone_number) {
            $channels[] = 'nexmo';
        }
        if ($notifiable->notification_slack_webhook) {
            $channels[] = 'slack';
        }

        return $channels;
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
                    ->subject($notifiable->description)
                    ->greeting('Hi,')
                    ->line("{$notifiable->description} just finished running.")
                    ->line($this->output);
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content($notifiable->description.' just finished running.');
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->content(config('app.name'))
            ->attachment(function (SlackAttachment $attachment) use ($notifiable) {
                $attachment
                    ->title('Totem Task')
                    ->content($notifiable->description.' just finished running.');
            });
    }
}
