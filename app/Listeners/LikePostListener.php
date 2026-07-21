<?php

namespace App\Listeners;

use App\Events\UserLikedEvent;
use App\Notifications\LikeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LikePostListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLikedEvent $event): void
    {
        if($event->user->id === $event->post->user_id)return ;
        
        $event->post->user->notify(
            new LikeNotification($event->user , $event->post)
        );
    }
}
