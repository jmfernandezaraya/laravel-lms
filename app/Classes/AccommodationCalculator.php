<?php

namespace App\Classes;

use Carbon\Carbon;

use App\Models\SuperAdmin\Course;

class AccommodationCalculator extends FrontendCalculator
{
    private
        $airport_pickup_fee = 0,
        $medical_insurance_fee = 0,
        $custodian_fee = 0,
        
        $duration,
        $fee = 0,
        $placement_fee = 0,
        $special_diet_fee = 0,
        $deposit = 0,
        $summer_fee = 0,
        $christmas_fee = 0,
        $under_age_fee = 0,
        $discount,
        $peak_fee = 0,

        $christmas_start_date,
        $christmas_end_date,

        $fee_per_week = 0,
        $x_week_selected,
        $x_week_start_date,
        $x_week_end_date,
        $how_many_week_free,

        $discount_start_date,
        $discount_end_date;

    /**
     * @return mixed
     */
    public function getAirportPickupFee()
    {
        return $this->airport_pickup_fee;
    }

    /**
     * @param mixed $airport_pickup_fee
     */
    public function setAirportPickupFee($airport_pickup_fee)
    {
        $this->airport_pickup_fee = $airport_pickup_fee;
    }

    /**
     * @return mixed
     */
    public function getMedicalInsuranceFee()
    {
        return $this->medical_insurance_fee;
    }

    /**
     * @param mixed $medical_insurance_fee
     */
    public function setMedicalInsuranceFee($medical_insurance_fee)
    {
        $this->medical_insurance_fee = $medical_insurance_fee;
    }

    /**
     * @return mixed
     */
    public function getCustodianFee()
    {
        return $this->custodian_fee;
    }

    /**
     * @param mixed $custodian_fee
     */
    public function setCustodianFee($custodian_fee)
    {
        $this->custodian_fee = $custodian_fee;
    }


    /**
     * @param mixed $christmas_start_date
     */
    public function setAccommodationChristmasStartDate($christmas_start_date): void
    {
        $this->christmas_start_date = $christmas_start_date;
    }

    /**
     * @param mixed $christmas_end_date
     */
    public function setAccommodationChristmasEndDate($christmas_end_date): void
    {
        $this->christmas_end_date = $christmas_end_date;
    }
    
    /**
     * @param mixed $duration
     */
    public function setAccommodationDuration($duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @param mixed $discount
     */
    public function setAccommodationDiscount($discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return mixed
     */
    public function getAccommodationFee()
    {
        return $this->fee;
    }

    /**
     * @param mixed $fee
     */
    public function setAccommodationFee($fee)
    {
        $this->fee = $fee;
    }

    /**
     * @return mixed
     */
    public function getAccommodationPlacementFee()
    {
        return $this->placement_fee;
    }

    /**
     * @param mixed $placement_fee
     */
    public function setAccommodationPlacementFee($placement_fee)
    {
        $this->placement_fee = $placement_fee;
    }

    /**
     * @return mixed
     */
    public function getAccommodationSpecialDietFee()
    {
        return $this->special_diet_fee;
    }

    /**
     * @param mixed $special_diet_fee
     */
    public function setAccommodationSpecialDietFee($special_diet_fee)
    {
        $this->special_diet_fee = $special_diet_fee;
    }

    /**
     * @return mixed
     */
    public function getAccommodationDeposit()
    {
        return $this->deposit;
    }

    /**
     * @param mixed $deposit
     */
    public function setAccommodationDeposit($deposit)
    {
        $this->deposit = $deposit;
    }

    public function getAccommodationPeakFee()
    {
        return $this->peak_fee;
    }

    /**
     * @param mixed $peak_fee
     */
    public function setAccommodationPeakFee($peak_fee): void
    {
        $this->peak_fee = $peak_fee;
    }

    /**
     * @return mixed
     */
    public function getAccommodationSummerFee()
    {
        return $this->summer_fee;
    }

    /**
     * @param mixed $summer_fee
     */
    public function setAccommodationSummerFee($summer_fee)
    {
        $this->summer_fee = $summer_fee;
    }

    /**
     * @return mixed
     */
    public function getAccommodationUnderageFee()
    {
        return $this->under_age_fee;
    }

    /**
     * @param mixed $under_age_fee
     */
    public function setAccommodationUnderageFee($under_age_fee)
    {
        $this->under_age_fee = $under_age_fee;
    }

    /**
     * @return mixed
     */
    public function getAccommodationChristmasFee()
    {
        return $this->christmas_fee;
    }

    /**
     * @param mixed $christmas_fee
     */
    public function setAccommodationChristmasFee($christmas_fee)
    {
        $this->christmas_fee = $christmas_fee;
    }

    /**
     * @param mixed $discount_start_date
     */
    public function setAccommodationDiscountStartDate($discount_start_date): void
    {
        $this->discount_start_date = $discount_start_date;
    }

    /**
     * @param mixed $discount_end_date
     */
    public function setAccommodationDiscountEndDate($discount_end_date): void
    {
        $this->discount_end_date = $discount_end_date;
    }

    /**
     * @return mixed
     */
    public function getAccommodationFeePerWeek()
    {
        return $this->fee_per_week;
    }

    /**
     * @param mixed $placement_fee
     */
    public function setAccommodationFeePerWeek($fee_per_week)
    {
        $this->fee_per_week = $fee_per_week;
    }

    /**
     * @param mixed $discount_start_date
     */
    public function setAccommodationXWeekSelected($x_week_selected): void
    {
        $this->x_week_selected = $x_week_selected;
    }

    /**
     * @param mixed $x_week_start_date
     */
    public function setAccommodationXWeekStartDate($x_week_start_date): void
    {
        $this->x_week_start_date = $x_week_start_date;
    }

    /**
     * @param mixed $x_week_end_date
     */
    public function setAccommodationXWeekEndDate($x_week_end_date): void
    {
        $this->x_week_end_date = $x_week_end_date;
    }

    /**
     * @param mixed $how_many_week_free
     */
    public function setAccommodationXWeekFee($how_many_week_free): void
    {
        $this->how_many_week_free = $how_many_week_free;
    }

    // Only Accommodation Total
    public function calculateOnlyAccommodationTotal()
    {
        $total = $this->fee +
            $this->placement_fee +
            $this->deposit +
            $this->summer_fee +
            $this->under_age_fee +
            $this->christmas_fee +
            $this->special_diet_fee +
            $this->peak_fee;

        insertCalculationIntoDB('accommodation_total', $total);
        return $total;
    }

    public function TotalCalculation()
    {
        $total = readCalculationFromDB('total') + readCalculationFromDB('accommodation_total') + readCalculationFromDB('accommodation_special_diet_fee') + readCalculationFromDB('airport_pickup_fee') + readCalculationFromDB('medical_insurance_fee');
        return $total - readCalculationFromDB('discount_fee') - readCalculationFromDB('accommodation_discount');
    }

    public function resultAccommodationDiscount()
    {
        $discount_total = 0;
        if (checkBetweenDate($this->x_week_start_date, $this->x_week_end_date, Carbon::now()->format('Y-m-d'))) {
            if ($this->x_week_selected) {
                $discount_total = $this->fee_per_week * (int)((int)$this->duration / (int)$this->x_week_selected) * $this->how_many_week_free;
            } else {
                $discount_total = 0;
            }
        } else if (checkBetweenDate($this->discount_start_date, $this->discount_end_date, Carbon::now()->format('Y-m-d'))) {
            $get_symbol = explode(" ", $this->discount);

            // We are calculating discount based on % or - here
            $discount_total = $get_symbol[1] == '%' ? (($this->fee / 100) * $get_symbol[0]) : ((float)$this->discount * (float)$this->duration);
        }
        return $discount_total;
    }

    /**
     * @param mixed $date1 , $date2, $date3, $date4+
     *
     * return array
     *
     * result will be weeks
     */
    public function CompareDatesandGetWeeksAccommodation(): array
    {
        $multiply['summer'] = 0 ;
        if (!($this->getProgramStartDateFromFrontend() > $this->getAccommodationSummerEndDate()) && !($this->getFrontEndDate() < $this->getAccommodationSummerStartDate())) {
            if ($this->getProgramStartDateFromFrontend() <= $this->getAccommodationSummerStartDate() && $this->getFrontEndDate() >= $this->getAccommodationSummerEndDate()) {
                $multiply['summer'] = $this->compareBetweenTwoDates($this->getAccommodationSummerStartDate(), $this->getAccommodationSummerEndDate());
            } elseif ($this->getProgramStartDateFromFrontend() <= $this->getAccommodationSummerStartDate() && $this->getFrontEndDate() <= $this->getAccommodationSummerEndDate()) {
                $multiply['summer'] = $this->compareBetweenTwoDates($this->getAccommodationSummerStartDate(), $this->getFrontEndDate());
            } elseif ($this->getProgramStartDateFromFrontend() >= $this->getAccommodationSummerStartDate() && $this->getFrontEndDate() <= $this->getAccommodationSummerEndDate()) { 
                $multiply['summer'] = $this->compareBetweenTwoDates($this->getProgramStartDateFromFrontend(), $this->getFrontEndDate());
            } elseif ($this->getProgramStartDateFromFrontend() >= $this->getAccommodationSummerStartDate() && $this->getFrontEndDate() >= $this->getAccommodationSummerEndDate()) {
                $multiply['summer'] = $this->compareBetweenTwoDates($this->getProgramStartDateFromFrontend(), $this->getAccommodationSummerEndDate());
            }
        }

        $multiply['peak'] = 0;
        if (!($this->getProgramStartDateFromFrontend() > $this->getAccommodationPeakEndDate()) && !($this->getFrontEndDate() < $this->getAccommodationPeakStartDate())) {
            if ($this->getProgramStartDateFromFrontend() <= $this->getAccommodationPeakStartDate() && $this->getFrontEndDate() >= $this->getAccommodationPeakEndDate()) {
                $multiply['peak'] = $this->compareBetweenTwoDates($this->getAccommodationPeakStartDate(), $this->getAccommodationPeakEndDate());
            } elseif ($this->getProgramStartDateFromFrontend() <= $this->getAccommodationPeakStartDate() && $this->getFrontEndDate() <= $this->getAccommodationPeakEndDate()) {
                $multiply['peak'] = $this->compareBetweenTwoDates($this->getAccommodationPeakStartDate(), $this->getFrontEndDate());
            } elseif ($this->getProgramStartDateFromFrontend() >= $this->getAccommodationPeakStartDate() && $this->getFrontEndDate() <= $this->getAccommodationPeakEndDate()) { 
                $multiply['peak'] = $this->compareBetweenTwoDates($this->getProgramStartDateFromFrontend(), $this->getFrontEndDate());
            } elseif ($this->getProgramStartDateFromFrontend() >= $this->getAccommodationPeakStartDate() && $this->getFrontEndDate() >= $this->getAccommodationPeakEndDate()) {
                $multiply['peak'] = $this->compareBetweenTwoDates($this->getProgramStartDateFromFrontend(), $this->getAccommodationPeakEndDate());
            }
        }

        $multiply['christmas'] = 0;
        if (!($this->getProgramStartDateFromFrontend() > $this->christmas_end_date) && !($this->getFrontEndDate() < $this->christmas_start_date)) {
            if ($this->getProgramStartDateFromFrontend() <= $this->christmas_start_date && $this->getFrontEndDate() >= $this->christmas_end_date) {
                $multiply['christmas'] = $this->compareBetweenTwoDates($this->christmas_start_date, $this->christmas_end_date);
            } elseif ($this->getProgramStartDateFromFrontend() <= $this->christmas_start_date && $this->getFrontEndDate() <= $this->christmas_end_date) {
                $multiply['christmas'] = $this->compareBetweenTwoDates($this->christmas_start_date, $this->getFrontEndDate());
            } elseif ($this->getProgramStartDateFromFrontend() >= $this->christmas_start_date && $this->getFrontEndDate() <= $this->christmas_end_date) {
                $multiply['christmas'] = $this->compareBetweenTwoDates($this->getProgramStartDateFromFrontend(), $this->getFrontEndDate());
            } elseif ($this->getProgramStartDateFromFrontend() >= $this->christmas_start_date && $this->getFrontEndDate() >= $this->christmas_end_date) {
                $multiply['christmas'] = $this->compareBetweenTwoDates($this->getProgramStartDateFromFrontend(), $this->christmas_end_date);
            }
        }

        return $multiply;
    }
}