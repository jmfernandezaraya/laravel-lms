<?php

namespace App\Console\Commands;

use App\Models\CourseApplication;

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
        $course_applications = CourseApplication::with('getCourseProgram', 'User')
            ->where('end_date', $now)
            ->get();
        if (!$course_applications->isEmpty()){
            foreach ($course_applications as $course_application) {
                $course_application->notify(new ApplicationNotificationToStudent($course_application));
            }
        }

        $before_two_days = Carbon::now()->subDays(2)->format('Y-m-d');
        $course_applications = CourseApplication::with('getCourseProgram', 'User')->doesntHave('review')
            ->whereDate('created_at', $before_two_days)
            ->get();
        if (!$course_applications->isEmpty()){
            foreach ($course_applications as $course_application) {
                $course_application->notify(new ApplicationNotificationToAdmin($course_application));
            }
        }

        $after_two_days = Carbon::now()->addDays(2)->format('Y-m-d');
        return 0;
    }
}