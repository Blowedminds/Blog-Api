<?php

namespace App\Events;

use App\RoomMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewMessageEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room_message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(RoomMessage $room_message)
    {
        $this->room_message = $room_message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel($this->room_message->room->article->slug);
    }

    public function broadcastAs()
    {
        return 'new_message.created';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->room_message->message,
            'slug' => $this->room_message->room->article->slug,
            'user_id' => $this->room_message->user->user_id,
            'user_name' => $this->room_message->user->name
        ];
    }
}
