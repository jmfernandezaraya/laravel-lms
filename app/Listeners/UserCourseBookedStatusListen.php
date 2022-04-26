<?php

namespace App\Listeners;

use App\Events\UserCourseBookedStatus;
use App\Models\Calculator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserCourseBookedStatusListen
{
    /**
     * Handle the event.
     *
     * @param  UserCourseBookedStatus  $userCourseBookedStatus
     * @return void
     */
    public function handle(UserCourseBookedStatus $userCourseBookedStatus)
    {
        return \App\Models\UserCourseBookedStatus::updateOrCreate(
            ['user_course_booked_detail_id' => $userCourseBookedStatus->userCourseBookedStatus->id, 'status' =>$userCourseBookedStatus->userCourseBookedStatus->status],
            ['user_course_booked_detail_id' => $userCourseBookedStatus->userCourseBookedStatus->id, 'status' => $userCourseBookedStatus->userCourseBookedStatus->status]
        );
    }
}
