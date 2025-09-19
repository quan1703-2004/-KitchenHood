<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $message;
    public $senderId;
    public $senderType;

    /**
     * Create a new event instance.
     */
    public function __construct($username, $message, $senderId = null, $senderType = 'user')
    {
        $this->username = $username;
        $this->message = $message;
        $this->senderId = $senderId;
        $this->senderType = $senderType;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('chat-channel'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'message';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'username' => $this->username,
            'message' => $this->message,
            'senderId' => $this->senderId,
            'senderType' => $this->senderType,
            'timestamp' => now()->setTimezone('Asia/Ho_Chi_Minh')->format('H:i'),
            'timestamp_full' => now()->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i')
        ];
    }
}