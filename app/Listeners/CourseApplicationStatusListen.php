<?php

namespace App\Listeners;

use App\Events\CourseApplicationStatus;
use App\Models\Calculator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseApplicationStatusListen
{
    /**
     * Handle the event.
     *
     * @param  CourseApplicationStatus  $courseApplicationStatus
     * @return void
     */
    public function handle(CourseApplicationStatus $courseApplicationStatus)
    {
        return \App\Models\CourseApplicationStatus::updateOrCreate(
            ['course_application_id' => $courseApplicationStatus->courseApplicationStatus->id, 'status' =>$courseApplicationStatus->courseApplicationStatus->status],
            ['course_application_id' => $courseApplicationStatus->courseApplicationStatus->id, 'status' => $courseApplicationStatus->courseApplicationStatus->status]
        );
    }
}
