<?php

namespace App\Listeners;

use App\Events\ThreadWasReplied;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\ReplyWasAdded;

class NotifySubscribers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadWasReplied  $event
     * @return void
     */
    public function handle(ThreadWasReplied $event)
    {
        $event->reply->thread->subscriptions
                ->where('user_id','<>',auth()->id())
                ->each
                ->notify(new ReplyWasAdded($event->reply->thread));
        
    }
}
