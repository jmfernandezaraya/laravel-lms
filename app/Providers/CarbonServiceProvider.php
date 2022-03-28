<?php
namespace App\Providers;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\ServiceProvider;

/**
 * Class CarbonServiceProvider
 */
class CarbonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::macro('programEndDateExcludingLastWeekend', function ($start_date, $addweeks) {
            $start_date_dt = $start_date->format('d-m-Y');
            $end_date_dt = $start_date->addWeeks($addweeks)->format('d-m-Y');

            $dateRange = CarbonPeriod::create($start_date_dt, $end_date_dt);

            $datess = [];
            foreach ($dateRange as $dates) {
                if (!$dates->isWeekend() && $dates->isFriday()) {
                    $datess[] = $dates->format('d-m-Y');
                }
            }

            return end($datess);
        });
    }
}