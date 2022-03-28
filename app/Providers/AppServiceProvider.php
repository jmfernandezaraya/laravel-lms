<?php

namespace App\Providers;

use App\Classes\SendCourseNotificationToStudent;
use App\Jobs\CourseAutoSendNotification;
use App\Models\UserCourseBookedDetails;
use App\Notifications\BirthdayNotification;
use App\Notifications\CourseNotificationToStudent;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }
}