<?php

namespace App\Console\Commands;

use App\Models\UserCourseBookedDetails;

use App\Notifications\ApplicationNotificationToStudent;
use App\Notifications\ApplicationNotificationToAdmin;

use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Class ApplicationSendNotification
 * @package App\Console\Commands
 */
class ApplicationSendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:applicationsendreminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Application Reminder For User';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now()->format('Y-m-d');
        $course_booked_details = UserCourseBookedDetails::with('getCourseProgram', 'User')
            ->where('end_date', $now)
            ->get();
        if (!$course_booked_details->isEmpty()){
            foreach ($course_booked_details as $course_booked_detail) {
                $course_booked_detail->notify(new ApplicationNotificationToStudent($course_booked_detail));
            }
        }

        $before_two_days = Carbon::now()->subDays(2)->format('Y-m-d');
        $course_booked_details = UserCourseBookedDetails::with('getCourseProgram', 'User')->doesntHave('review')
            ->whereDate('created_at', $before_two_days)
            ->get();
        if (!$course_booked_details->isEmpty()){
            foreach ($course_booked_details as $course_booked_detail) {
                $course_booked_detail->notify(new ApplicationNotificationToAdmin($course_booked_detail));
            }
        }

        $after_two_days = Carbon::now()->addDays(2)->format('Y-m-d');
        return 0;
    }
}