<?php

namespace App\Console\Commands;

use App\Models\CourseApplication;

use App\Notifications\CourseNotificationToStudent;

use Carbon\Carbon;
use Illuminate\Console\Command;

class BirthdayNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:birthday_notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Birthday Notification';

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
        $now = now()->format('Y-m-d');
        $coursemodal = CourseApplication::where('dob', $now)->get();

        if(!$coursemodal->isEmpty()){
            foreach ($coursemodal as $values) {
                $values->notify(new \App\Notifications\BirthdayNotification($values));
            }
        }
        return 0;
    }
}