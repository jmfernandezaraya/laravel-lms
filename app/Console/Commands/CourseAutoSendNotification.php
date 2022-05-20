<?php

namespace App\Console\Commands;

use App\Models\UserCourseBookedDetails;
use App\Notifications\CourseNotificationToStudent;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Class CourseAutoSendNotification
 * @package App\Console\Commands
 */
class CourseAutoSendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:courseautosendreminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Course Reminder For User';

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
        $twoWeek = Carbon::now()->addWeeks(4)->format('Y-m-d');
        $oneWeek = Carbon::now()->addWeek()->format('Y-m-d');
        $coursemodal = UserCourseBookedDetails::with('getCourseProgram')->join('courses_programs', 'user_course_booked_details.course_program_id', 'course_programs.unique_id')
            ->select('user_course_booked_details.*', 'courses_programs.program_start_date AS psd')
            ->where('courses_programs.program_start_date', $twoWeek)->orWhere('courses_programs.program_start_date', $oneWeek)
            ->get();

        if(!$coursemodal->isEmpty()){
            foreach ($coursemodal as $values) {
                $values->notify(new CourseNotificationToStudent($values));
            }
        }
        return 0;
    }
}