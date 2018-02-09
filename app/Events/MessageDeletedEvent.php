<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class MessageDeletedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message_id;

    public $slug;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message_id, $slug)
    {
        $this->message_id = $message_id;

        $this->slug = $slug;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel($this->slug);
    }

    public function broadcastAs()
    {
        return 'message.deleted';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message_id
        ];
    }
}
