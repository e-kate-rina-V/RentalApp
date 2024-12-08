<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportGenerated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $fileName;
    public string $message;

    public function __construct(string $fileName, string $message)
    {
        $this->fileName = $fileName;
        $this->message = $message;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('reports');
    }
}
