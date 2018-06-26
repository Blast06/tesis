<?php

namespace App\Events;

use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CartStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $itemCount;

    /**
     * @var \App\User
     */
    private $user;

    /**
     * Create a new event instance.
     *
     * @param \App\User $user
     */
    public function __construct(User $user)
    {
        $this->itemCount = auth()->user()->articles()->sum('quantity');
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function broadcastWith()
    {
        return [
            'count' => $this->itemCount
        ];
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return 'listenCarItem';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('Cart.User.' . $this->user->id);
    }
}
