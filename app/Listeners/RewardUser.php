<?php

namespace App\Listeners;

use App\Events\UserReferred;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RewardUser
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
     * @param  UserReferred  $event
     * @return void
     */
    public function handle(UserReferred $event)
    {
        if (!is_null($event->referralId)) {
            $event->user->parent_id = $event->referralId;
            $event->user->save();
        }
    }
}
