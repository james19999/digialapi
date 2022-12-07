<?php

namespace App\Listeners;

use App\Events\NewSubscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailNotification
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
     * @param  \App\Events\NewSubscription  $event
     * @return void
     */
    public function handle(NewSubscription $event)
    {
        //
    }
}
