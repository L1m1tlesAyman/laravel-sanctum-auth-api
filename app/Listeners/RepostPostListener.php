<?php

namespace App\Listeners;

use App\Events\UserRepostedEvent;
use App\Notifications\RepostNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RepostPostListener
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
    public function handle(UserRepostedEvent $event): void
    {
        //
        if($event->user->id === $event->post->user_id)return;

        $event->post->user->notify(
            new RepostNotification($event->user , $event->post)
        );
    }
}
