<?php

namespace App\Notifications\System;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class GenericNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param string $type info, warning, danger, success
     */
    public function __construct(

        private readonly string  $text,
        private readonly Carbon  $date,
        private readonly string  $url,
        private readonly string  $type = 'info', // info, warning, danger, success
        private readonly ?string $uid = null
    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'uid' => $this->uid,
            'text' => $this->text,
            'date' => $this->date,
            'type' => $this->type,
            'url' => $this->url,
        ];
    }
}
