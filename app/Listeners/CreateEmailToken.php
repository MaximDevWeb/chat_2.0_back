<?php

namespace App\Listeners;

use App\Events\UserCreated;

class CreateEmailToken
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
    public function handle(UserCreated $event): void
    {
        $event->user->emailToken()->create([
            'token' => md5(microtime()),
        ]);
    }
}
