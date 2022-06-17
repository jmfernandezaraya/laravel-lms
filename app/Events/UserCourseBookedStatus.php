<?php

namespace App\Events;

use App\Models\CourseApplication;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseApplicationStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $courseApplicationStatus;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CourseApplication $courseApplicationStatus)
    {
        $this->courseApplicationStatus = $courseApplicationStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
