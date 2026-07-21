<?php

namespace App\Listeners;

use App\Events\UserCommentedEvent;
use App\Notifications\CommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentPostListener
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
    public function handle(UserCommentedEvent $event): void
    {
        //
        if($event->user->id === $event->post->user_id)return ;
        
        $event->post->user->notify(
            new CommentNotification($event->user , $event->post)
        );
    }
}
