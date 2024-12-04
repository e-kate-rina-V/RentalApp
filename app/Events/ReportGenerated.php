<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportGenerated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $filePath;

    public function __construct($userId, $filePath)
    {
        $this->userId = $userId;
        $this->filePath = $filePath;
    }

    public function broadcastOn()
    {
        return new Channel('user.' . $this->userId);
    }
}
