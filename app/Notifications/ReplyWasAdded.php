<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class ReplyWasAdded extends Notification
{
    

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $thread;
    public function __construct($thread)
    {
      $this->thread = $thread;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'message' => auth()->user()->name.' just replied to '.$this->thread->title,
            'link' => $this->thread->path()
        ];
    }
}
