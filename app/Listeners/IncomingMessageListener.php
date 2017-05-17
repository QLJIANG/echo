<?php

namespace App\Listeners;

use App\Events\IncomingMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Message;

class IncomingMessageListener
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
     * @param  IncomingListener  $event
     * @return void
     */
    public function handle(IncomingMessage $event)
    {
        Message::create([
            'from_user_id' => $event->from->id,
            'to_user_id' => $event->to->id,
            'from_to' => $event->from->id * $event->to->id,
            'body' => $event->body,
        ]);
    }
}
