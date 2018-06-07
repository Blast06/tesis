<?php

namespace App\Events;

use App\{Conversation, Message};
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Conversation
     */
    public $conversation;

    /**
     * @var \App\Message
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @param \App\Conversation $conversation
     * @param \App\Message $message
     */
    public function __construct(Conversation $conversation, Message $message)
    {
        $this->conversation = $conversation;
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'message' => $this->message,
        ];
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return 'newMessage';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('Conversation.' . $this->conversation->id);
    }
}
