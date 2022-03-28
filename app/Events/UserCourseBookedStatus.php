<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\UserCourseBookedDetails;

class UserCourseBookedStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userCourseBookedStatus;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserCourseBookedDetails $userCourseBookedStatus)
    {
        $this->userCourseBookedStatus = $userCourseBookedStatus;
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
