<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApiCallFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $url;
    public $requestData;
    public $errorMessage;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($url, $requestData, $errorMessage)
    {
        $this->url = $url;
        $this->requestData = $requestData;
        $this->errorMessage = $errorMessage;
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
        return (new MailMessage)
            ->subject(__('Api Call Failure !'))
            ->greeting('Hello ')
            ->line(__('You have an appointment for errors in thr system'))
            ->action(__('Complete Your Profile'), $this->url)
            ->line(__('The requested data was' . ' ' . $this->requestData))
            ->line(__('Error message' . ' ' . $this->errorMessage))
            ->line(__('Kind regards' ));

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
            'url' => $this->url,
            'requestData' => $this->requestData,
            'errorMessage' => $this->errorMessage,
        ];
    }
}
