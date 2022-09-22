<?php

namespace App\Classes;

use DB;
use Exception;

use Carbon\Carbon;

use App\Models\SuperAdmin\Course;
use App\Models\SuperAdmin\CurrencyExchangeRate;

class FrontendCalculator
{
    private
        $program_cost,
        $program_registration_fee,
        $fixed_program_cost,
        $summer_end_date_program,
        $program_duration,
        $text_book_fee,
        $summer_fee,
        //$christmas_fee,
        $program_start_date_from_frontend,
        $under_age_fee,
        $mail_fee,
        $discount,

        $program_start_date,
        $program_end_date,

        $forpercentage = 0,

        $peak_time_fee = 0,
        $peak_start_date,
        $peak_end_date,
        $summer_start_date_program,
        $summer_date_from_db_program,

        $discount_week_get = 0,
        $how_many_week_free,
        $discount_start_date,
        $discount_end_date,
        $discount_start_date_for_week_select,
        $discount_end_date_for_week_select,

        $get_program_weeks,

        $accomodation_peak_end_date,
        $accomodation_peak_start_date,
        $accomodation_summer_start_date,
        $accomodation_summer_end_date,

        $front_end_date;

    /**
     * @return mixed
     */
    public function getAccommodationPeakEndDate()
    {
        return $this->accomodation_peak_end_date;
    }

    /**
     * @param mixed $accomodation_peak_end_date
     */
    public function setAccommodationPeakEndDate($accomodation_peak_end_date)
    {
        $this->accomodation_peak_end_date = $accomodation_peak_end_date;
    }

    /**
     * @return mixed
     */
    public function getAccommodationSummerStartDate()
    {
        return $this->accomodation_summer_start_date;
    }

    /**
     * @param mixed $accomodation_summer_start_date
     */
    public function setAccommodationSummerStartDate($accomodation_summer_start_date)
    {
        $this->accomodation_summer_start_date = $accomodation_summer_start_date;
    }

    /**
     * @return mixed
     */
    public function getAccommodationSummerEndDate()
    {
        return $this->accomodation_summer_end_date;
    }

    public function setAccommodationSummerEndDate($accomodation_summer_end_date)
    {
        $this->accomodation_summer_end_date = $accomodation_summer_end_date;
    }

    /**
     * @param mixed $program_start_date_from_frontend
     */
    public function setProgramStartDateFromFrontend($program_start_date_from_frontend)
    {
        $this->program_start_date_from_frontend = $program_start_date_from_frontend;
    }

    /**
     * @return mixed
     */
    public function getAccommodationPeakStartDate()
    {
        return $this->accomodation_peak_start_date;
    }

    /**
     * @param mixed $accomodation_peak_start_date
     */
    public function setAccommodationPeakStartDate($accomodation_peak_start_date)
    {
        $this->accomodation_peak_start_date = $accomodation_peak_start_date;
    }

    /**
     * @param mixed $summer_end_date
     */
    public function setSummerEndDateProgram($summer_end_date_program)
    {
        $this->summer_end_date_program = $summer_end_date_program;
    }

    /**
     * @param mixed $front_end_date
     */
    public function setFrontEndDate($front_end_date)
    {
        $this->front_end_date = $front_end_date;
    }

    /**
     * @param mixed $summer_start_date_program
     */
    public function setSummerStartDateProgram($summer_start_date_program)
    {
        $this->summer_start_date_program = $summer_start_date_program;
    }

    /**
     * @param mixed $summer_date_from_db_program
     */
    public function setSummerDateFromDbProgram($summer_date_from_db_program)
    {
        $this->summer_date_from_db_program = $summer_date_from_db_program;
    }

    /**
     * @param mixed $peak_date_from_db_program
     */
    public function setPeakDateFromDbProgram($peak_end_date)
    {
        $this->peak_end_date = $peak_end_date;
    }

    /**
     * @param mixed $program_duration
     */
    public function setProgramDuration($program_duration)
    {
        $this->program_duration = $program_duration;
    }

    /**
     * @param int $peak_time_fee
     */
    public function setPeakTimeFee(int $peak_time_fee)
    {
        $this->peak_time_fee = $peak_time_fee;
    }

    /**
     * @param mixed $peak_start_date
     */
    public function setPeakStartDate($peak_start_date)
    {
        $this->peak_start_date = $peak_start_date;
    }

    /**
     * @param mixed $peak_end_date
     */
    public function setPeakEndDate($peak_end_date)
    {
        $this->peak_end_date = $peak_end_date;
    }

    /**
     * @param mixed $fixed_program_cost
     */
    public function setFixedProgramCost($fixed_program_cost)
    {
        $this->fixed_program_cost = $fixed_program_cost;
    }

    /**
     * @param int $forpercentage
     */
    public function setForpercentage(int $forpercentage)
    {
        $this->forpercentage = $forpercentage;
    }

    /**
     * @param mixed $program_start_date
     */
    public function getProgramStartDate()
    {
        return $this->program_start_date;
    }

    /**
     * @param mixed $program_start_date
     */
    public function setProgramStartDate($program_start_date)
    {
        $this->program_start_date = $program_start_date;
    }

    /**
     * @param mixed $program_end_date
     */
    public function getProgramStartEnd()
    {
        return $this->program_end_date;
    }

    /**
     * @param mixed $program_end_date
     */
    public function setProgramEndDate($program_end_date)
    {
        $this->program_end_date = $program_end_date;
    }

    /**
     * @param mixed $discount_start_date_for_week_select
     */
    public function setDiscountStartDateForWeekSelect($discount_start_date_for_week_select)
    {
        $this->discount_start_date_for_week_select = $discount_start_date_for_week_select;
    }

    /**
     * @param mixed $discount_end_date_for_week_select
     */
    public function setDiscountEndDateForWeekSelect($discount_end_date_for_week_select)
    {
        $this->discount_end_date_for_week_select = $discount_end_date_for_week_select;
    }

    /**
     * @param mixed $get_program_weeks
     */
    public function setGetProgramWeeks($get_program_weeks)
    {
        $this->get_program_weeks = $get_program_weeks;
    }

    /**
     * @param mixed $discount_start_date
     */
    public function setDiscountStartDate($discount_start_date)
    {
        $this->discount_start_date = $discount_start_date;
    }

    /**
     * @param mixed $discount_end_date
     */
    public function setDiscountEndDate($discount_end_date)
    {
        $this->discount_end_date = $discount_end_date;
    }

    public function setDiscountWeekGet($cost)
    {
        $this->discount_week_get = $cost;
    }

    public function setHowManyWeekFree($cost)
    {
        $this->how_many_week_free = $cost;
    }

    public function setProgramCost($cost)
    {
        $this->program_cost = $cost == null ? 0 : $cost;
    }

    public function setProgramRegistrationFee($cost)
    {
        $this->program_registration_fee = $cost == null ? 0 : $cost;
    }

    public function setTextBookFee($cost)
    {
        $this->text_book_fee = $cost == null ? 0 : $cost;
    }

    public function setSummerFee($cost)
    {
        $this->summer_fee = $cost == null ? 0 : $cost;
    }

    // public function setChristmasFee($cost)
    // {
    //     $this->christmas_fee = $cost == null ? 0 : $cost;
    // }

    public function setUnderAgeFee($cost)
    {
        $this->under_age_fee = $cost == null ? 0 : $cost;
    }

    public function setCouponDiscount($cost)
    {
        $this->coupon_discount = $cost == null ? 0 : $cost;
    }

    public function setCouponDiscountConverted($cost)
    {
        $this->coupon_discount_converted = $cost == null ? 0 : $cost;
    }

    public function setTotalPrice()
    {
        $total =
            $this->program_cost +
            $this->program_registration_fee +
            $this->text_book_fee +
            $this->summer_fee +
            $this->under_age_fee +
            $this->peak_time_fee +
            $this->mail_fee;

        insertCalculationIntoDB('total', $total);
    }

    public function setDiscount($cost)
    {
        $this->discount = $cost == null ? 0 : $cost;
        return $this;
    }

    public function setCourierFee($cost)
    {
        $this->mail_fee = $cost;
        return $this;
    }

    public function discountedTotal()
    {
        $discounted_total = 0;
        insertCalculationIntoDB('discount_fee', $discounted_total);

        if (checkBetweenDate($this->discount_start_date_for_week_select, $this->discount_end_date_for_week_select, Carbon::now()->format('Y-m-d'))) {
            // Calculating by program cost * week  - free_week
            $divide = $this->divideProgramDurationByWeekSelect($this->program_duration, $this->discount_week_get);

            $data['total'] = $this->fixed_program_cost * $divide * $this->how_many_week_free;

            //Calculating discount fee here and inserting into db
            insertCalculationIntoDB('discount_fee', $this->fixed_program_cost * $divide * $this->how_many_week_free);

            $firstdiscount = $discounted_total = $this->program_cost - $data['total'];

            if (isset($firstdiscount) && checkBetweenDate($this->discount_start_date, $this->discount_end_date, Carbon::now()->format('Y-m-d'))) {
                $explode_first = explode(" ", $this->discount);
                $number = $explode_first[0];
                $cal_symbol = $explode_first[1];
                $totals = $data['total'];
                if ($cal_symbol == '%') {
                    $data['totals'] = ((float)$totals / 100) * $number;
                } else {
                    $data['totals'] = ($this->discount * $this->program_duration);
                }

                $discount = readCalculationFromDB('discount_fee');
                $discounted_total = $this->program_cost - $data['totals'];   //This is calculating discount from program cost

                $total = $discount + $data['totals'];

                /*
                * Second insertion of discount fee if the date range is matched
                */
                insertCalculationIntoDB('discount_fee', $total);
                $data['program_cost'] = readCalculationFromDB('program_cost');
                $data['discount'] = readCalculationFromDB('discount_fee');

                $totalss = readCalculationFromDB('program_cost') + readCalculationFromDB('program_registration_fee') + 
                    readCalculationFromDB('text_book_fee') + readCalculationFromDB('summer_fee') +
                    // readCalculationFromDB('christmas_fee') +
                    readCalculationFromDB('under_age_fee') + readCalculationFromDB('courier_fee');
                $minus = $totalss - $data['discount'];
                $set_total = $minus + $totalss;
                DB::transaction(function () use ($set_total, $total) {
                    insertCalculationIntoDB('total', $set_total);
                });
                $discounted_total = isset($firstdiscount) ? $firstdiscount + $discounted_total : $discounted_total;
            }
        } elseif (checkBetweenDate($this->program_start_date, $this->program_end_date, Carbon::now()->format('Y-m-d'))) {
            /*
             * Second insertion of discount fee if the date range is matched
            */
            $explode_first = explode(" ", $this->discount);

            $number = $explode_first[0];
            $cal_symbol = $explode_first[1];

            $totals = $this->program_cost;
            if ($cal_symbol == '%') {
                $data['totals'] = ((float)$totals / 100) * $number;
            } else {
                $data['totals'] = (float)$this->discount * (float)$this->program_duration;
            }

            $discounted_total = $this->program_cost - $data['totals'];   //This is calculating discount from program cost
            $total = $data['totals'];

            /*
             * Second time program cost reduce
             * if the valid period ate condition is set
            */
            insertCalculationIntoDB('discount_fee', $total);
            $data['program_cost'] = readCalculationFromDB('program_cost');
            $data['discount'] = readCalculationFromDB('discount_fee');

            $totalss = readCalculationFromDB('program_cost') + readCalculationFromDB('program_registration_fee') + 
                readCalculationFromDB('text_book_fee') + readCalculationFromDB('summer_fee') + 
                // readCalculationFromDB('christmas_fee') + 
                readCalculationFromDB('under_age_fee') + readCalculationFromDB('courier_fee');
            $minus = $totalss - $data['discount'];
            $set_total = $minus + $totalss;
            DB::transaction(function () use ($set_total, $total) {
                insertCalculationIntoDB('total', $set_total);
            });
        }
        return $discounted_total;
    }

    protected function divideProgramDurationByWeekSelect($program_duration, $week_selected): int
    {
        if (!(int)$week_selected) return 0;
        return (int)((int)$program_duration / (int)$week_selected);
    }

    public function totalPrice()
    {
        return $this->program_cost +
            $this->program_registration_fee +
            $this->text_book_fee +
            $this->summer_fee +
            //$this->christmas_fee +
            $this->under_age_fee +
            $this->mail_fee;
    }

    public function CompareDatesAndGetResult()
    {
        $multiply = [];

        // Taking this from summer start date from db
        $multiply['front_end_date_check'] = $this->front_end_date;
        $multiply['front_end_date_exact'] = $this->front_end_date;
        $multiply['summer_date_check'] = $this->summer_start_date_program;
        $multiply['summer_date_program'] = 0;

        if (!($this->program_start_date_from_frontend > $this->summer_date_from_db_program) && !($this->getFrontEndDate() < $this->summer_start_date_program)) {
            if ($this->getFrontEndDate() >= $this->summer_date_from_db_program && $this->getProgramStartDateFromFrontend() <= $this->summer_start_date_program ) {
                $multiply['summer_date_program'] = compareBetweenTwoDates($this->summer_start_date_program, $this->summer_date_from_db_program);
            } elseif (($this->getFrontEndDate() < $this->summer_date_from_db_program && $this->summer_start_date_program > $this->getProgramStartDateFromFrontend())) {
                $multiply['summer_date_program'] = $this->getFrontEndDate() < $this->summer_date_from_db_program ?
                    compareBetweenTwoDates($this->getFrontEndDate(), $this->summer_start_date_program) :
                    compareBetweenTwoDates($this->getFrontEndDate(), $this->summer_date_from_db_program);
            } elseif ($this->getFrontEndDate() <= $this->summer_date_from_db_program && $this->getFrontEndDate() >= $this->summer_start_date_program) {
                $multiply['summer_date_program'] = compareBetweenTwoDates($this->program_start_date_from_frontend, $this->getFrontEndDate());
            } elseif ($this->getFrontEndDate() >= $this->summer_date_from_db_program && $this->program_start_date_from_frontend >= $this->summer_start_date_program) {
                $multiply['summer_date_program'] = compareBetweenTwoDates($this->program_start_date_from_frontend, $this->summer_date_from_db_program);
            }
        }

        $multiply['peak_date_program'] = 0;
        if (!($this->program_start_date_from_frontend > $this->peak_end_date) && !($this->getFrontEndDate() < $this->peak_start_date)) {
            if ($this->getFrontEndDate() >= $this->peak_end_date && $this->getProgramStartDateFromFrontend() <= $this->peak_start_date) {
                $multiply['peak_date_program'] = compareBetweenTwoDates($this->peak_start_date, $this->peak_end_date);
            } elseif (($this->getFrontEndDate() < $this->peak_end_date && $this->peak_start_date > $this->getProgramStartDateFromFrontend())) {
                $multiply['peak_date_program'] = $this->getFrontEndDate() < $this->peak_end_date ?
                    compareBetweenTwoDates($this->getFrontEndDate(), $this->peak_start_date) :
                    compareBetweenTwoDates($this->getFrontEndDate(), $this->peak_end_date);
            } elseif ($this->getFrontEndDate() <= $this->peak_end_date && $this->getFrontEndDate() >= $this->peak_start_date) {
                $multiply['peak_date_program'] = compareBetweenTwoDates($this->program_start_date_from_frontend, $this->getFrontEndDate());
            } elseif ($this->getFrontEndDate() >= $this->peak_end_date && $this->program_start_date_from_frontend >= $this->peak_start_date) {
                $multiply['peak_date_program'] = compareBetweenTwoDates($this->program_start_date_from_frontend, $this->peak_end_date);
            }
        }

        return $multiply;
    }

    /**
     * @return mixed
     */
    protected function getFrontEndDate()
    {
        return $this->front_end_date;
    }

    /**
     * @return mixed
     */
    public function getProgramStartDateFromFrontend()
    {
        return $this->program_start_date_from_frontend;
    }

    public function calculateDiscountWeekFree($value, $week_selected): bool
    {
        if ($week_selected == null) return false;
        $value = $value % $week_selected;

        if ($value == 0) {
            return true;
        }

        return false;
    }

    public function CurrencyConverted($course_id, $total)
    {
        $course = Course::where('unique_id', '' . $course_id)->first();
        $value = [];
        if ($course && $total > 0) {
            $value['currency'] = app()->getLocale() == 'en' ? $course->getCurrency->name : $course->getCurrency->name_ar;
            $value['price'] = round($total * $course->getCurrency->exchange_rate);
        }

        return $value;
    }

    public function CurrencyReverseConverted($course_id, $total)
    {
        $course = Course::where('unique_id', '' . $course_id)->first();
        $value = [];
        if ($course && $total > 0) {
            $value['currency'] = app()->getLocale() == 'en' ? $course->getCurrency->name : $course->getCurrency->name_ar;
            if ($course->getCurrency->exchange_rate) {
                $value['price'] = (float)(round((float)($total / $course->getCurrency->exchange_rate) * 100) / 100);
            } else {
                $value['price'] = 0;
            }
        }

        return $value;
    }

    public function CurrencyConvertedValue($course_id, $total)
    {
        $course = Course::where('unique_id', '' . $course_id)->first();
        $value = 0;
        if ($course && $total > 0) {
            $value = round($total * $course->getCurrency->exchange_rate);
        }

        return $value;
    }

    public function CurrencyReverseConvertedValue($course_id, $total)
    {
        $course = Course::where('unique_id', '' . $course_id)->first();
        $value = 0;
        if ($course && $total > 0) {
            if ($course->getCurrency->exchange_rate) {                
                $value = (float)(round((float)($total / $course->getCurrency->exchange_rate) * 100) / 100);
            } else {
                $value = 0;
            }
        }

        return $value;
    }

    public function CurrencyConvertedValues($course_id, $values)
    {
        $course = Course::where('unique_id', '' . $course_id)->first();
        $result_values = [
            'currency' => $course ? (app()->getLocale() == 'en' ? $course->getCurrency->name : $course->getCurrency->name_ar) : '',
            'values' => [],
        ];
        foreach ($values as $value) {
            $result_value = $value ? (float)$value : 0;
            if ($course) {
                $result_value = round($result_value * $course->getCurrency->exchange_rate);
            }
            $result_values['values'][] = $result_value;
        }

        return $result_values;
    }

    public function CurrencyReverseConvertedValues($course_id, $values)
    {
        $course = Course::where('unique_id', '' . $course_id)->first();
        $result_values = [
            'currency' => $course ? (app()->getLocale() == 'en' ? $course->getCurrency->name : $course->getCurrency->name_ar) : '',
            'values' => [],
        ];
        foreach ($values as $value) {
            $result_value = $value ? (float)$value : 0;
            if ($course) {
                if ($course->getCurrency->exchange_rate) {
                    $result_value = (float)($result_value * $course->getCurrency->exchange_rate);
                } else {
                    $result_value = 0;
                }
            }
            $result_values['values'][] = $result_value;
        }

        return $result_values;
    }

    public function GetDefaultCurrency()
    {
        $currency = CurrencyExchangeRate::where('is_default', true)->first();
        $value = [];
        if ($currency) {
            $value['currency'] = app()->getLocale() == 'en' ? $currency->name : $currency->name_ar;
            $value['rate'] = $currency->exchange_rate;
        }

        return $value;
    }

    public function GetDefaultCurrencyName()
    {
        $currency = CurrencyExchangeRate::where('is_default', true)->first();
        $value = '';
        if ($currency) {
            $value = app()->getLocale() == 'en' ? $currency->name : $currency->name_ar;
        }

        return $value;
    }
}
