<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendNotification extends Notification
{
    use Queueable;

    public $subject;
    public $greeting;
    public $line1;
    public $line2;
    public $action;
    public $url;
    public $line3;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subject, $greeting, $line1, $line2, $action, $url, $line3)
    {
        $this->subject = $subject;
        $this->greeting = $greeting;
        $this->line1 = $line1;
        $this->line2 = $line2;
        $this->action = $action;
        $this->url = $url;
        $this->line3 = $line3;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->greeting($this->greeting)
            ->line($this->line1)
            ->line($this->line2)
            ->action($this->action, $this->url)
            ->line($this->line3);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
