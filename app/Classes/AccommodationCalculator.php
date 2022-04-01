<?php

namespace App\Classes;

use Carbon\Carbon;

use App\Models\SuperAdmin\Course;

class AccommodationCalculator extends FrontendCalculator
{
    private
        $accommodation_fee = 0,
        $accommodation_placement_fee = 0,
        $accommodation_special_diet_fee = 0,
        $accommodation_deposit = 0,
        $accommodation_custodian_fee = 0,
        $accommodation_summer_fee = 0,
        $accommodation_christmas_fee = 0,
        $accommodation_under_age_fee = 0,
        $accommodation_discount,
        $accommodation_peak_fee = 0,

        $airport_pickup_fee = 0,
        $medical_insurance_fee = 0,
        $accom_duration,

        $christmas_start_date,
        $christmas_end_date,

        $accommodation_discount_start_date,
        $accommodation_discount_end_date;

    /**
     * @param mixed $christmas_start_date
     */
    public function setChristmasStartDate($christmas_start_date): void
    {
        $this->christmas_start_date = $christmas_start_date;
    }

    /**
     * @param mixed $christmas_end_date
     */
    public function setChristmasEndDate($christmas_end_date): void
    {
        $this->christmas_end_date = $christmas_end_date;
    }
    
    /**
     * @param mixed $accom_duration
     */
    public function setAccomDuration($accom_duration): void
    {
        $this->accom_duration = $accom_duration;
    }

    /**
     * @param mixed $accommodation_discount_start_date
     */
    public function setAccommodationDiscount($accommodation_discount): void
    {
        $this->accommodation_discount = $accommodation_discount;
    }

    /**
     * @param mixed $accommodation_discount_start_date
     */
    public function setAccommodationDiscountStartDate($accommodation_discount_start_date): void
    {
        $this->accommodation_discount_start_date = $accommodation_discount_start_date;
    }

    /**
     * @param mixed $accommodation_discount_end_date
     */
    public function setAccommodationDiscountEndDate($accommodation_discount_end_date): void
    {
        $this->accommodation_discount_end_date = $accommodation_discount_end_date;
    }

    /**
     * @return mixed
     */
    public function getAccommodationFee()
    {
        return $this->accommodation_fee;
    }

    /**
     * @param mixed $fee
     */
    public function setAccommodationFee($fee)
    {
        $this->accommodation_fee = $fee;
    }

    /**
     * @return mixed
     */
    public function getAccommodationPlacementFee()
    {
        return $this->accommodation_placement_fee;
    }

    /**
     * @param mixed $accommodation_placement_fee
     */
    public function setAccommodationPlacementFee($accommodation_placement_fee)
    {
        $this->accommodation_placement_fee = $accommodation_placement_fee;
    }

    /**
     * @return mixed
     */
    public function getAccommodationDeposit()
    {
        return $this->accommodation_deposit;
    }

    /**
     * @param mixed $deposit
     */
    public function setAccommodationDeposit($deposit)
    {
        $this->accommodation_deposit = $deposit;
    }

    /**
     * @return mixed
     */
    public function getAccommodationSummerFee()
    {
        return $this->accommodation_summer_fee;
    }

    /**
     * @param mixed $summer_fee
     */
    public function setAccommodationSummerFee($summer_fee)
    {
        $this->accommodation_summer_fee = $summer_fee;
    }

    /**
     * @return mixed
     */
    public function getAccommodationUnderageFee()
    {
        return $this->accommodation_under_age_fee;
    }

    /**
     * @param mixed $under_age_fee
     */
    public function setAccommodationUnderageFee($under_age_fee)
    {
        $this->accommodation_under_age_fee = $under_age_fee;
    }

    /**
     * @return mixed
     */
    public function getAccommodationChristmasFee()
    {
        return $this->accommodation_christmas_fee;
    }

    /**
     * @param mixed $christmas_fee
     */
    public function setAccommodationChristmasFee($christmas_fee)
    {
        $this->accommodation_christmas_fee = $christmas_fee;
    }

    /**
     * @return mixed
     */
    public function getAccommodationSpecialDietFee()
    {
        return $this->accommodation_special_diet_fee;
    }

    /**
     * @param mixed $special_diet_fee
     */
    public function setAccommodationSpecialDietFee($special_diet_fee)
    {
        $this->accommodation_special_diet_fee = $special_diet_fee;
    }

    /**
     * @return mixed
     */
    public function getAccommodationCustodianFee()
    {
        return $this->accommodation_custodian_fee;
    }

    /**
     * @param mixed $custodian_fee
     */
    public function setAccommodationCustodianFee($custodian_fee)
    {
        $this->accommodation_custodian_fee = $custodian_fee;
    }

    public function getAccommodationPeakFee()
    {
        return $this->accommodation_peak_fee;
    }

    /**
     * @param mixed $peak_fee
     */
    public function setAccommodationPeakFee($peak_fee): void
    {
        $this->accommodation_peak_fee = $peak_fee;
    }

    // Only Accommodation Total
    public function calculateOnlyAccommodationTotal()
    {
        $total = $this->accommodation_fee +
            $this->accommodation_placement_fee +
            $this->accommodation_deposit +
            $this->accommodation_summer_fee +
            $this->accommodation_under_age_fee +
            $this->accommodation_christmas_fee +
            $this->accommodation_special_diet_fee +
            $this->accommodation_custodian_fee +
            $this->accommodation_peak_fee;

        insertCalculationIntoDB('accommodation_total', $total);
        return $total;
    }

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

    public function TotalCalculation()
    {
        $total = readCalculationFromDB('total') + readCalculationFromDB('accommodation_total') + readCalculationFromDB('airport_pickup_fee') +  readCalculationFromDB('medical_insurance_fee') + readCalculationFromDB('accommodation_special_diet_fee');
        return $total - readCalculationFromDB('discount_fee') - readCalculationFromDB('accommodation_discount');
    }

    public function resultAccommodationDiscount()
    {
        $discount_total = 0;
        if ($this->checkBetweenDate($this->accommodation_discount_start_date, $this->accommodation_discount_end_date, Carbon::now()->format('Y-m-d'))) {
            $get_symbol = explode(" ", $this->accommodation_discount);

            //We are calculating discount based on % or - here
            $discount_total = $get_symbol[1] == '%' ? (($this->accommodation_fee / 100) * $get_symbol[0]) : ((float)$this->accommodation_discount * (float)$this->accom_duration);
        }
        return $discount_total;
    }

    /**
     * @param mixed $date1 , $date2,
     * $date3, $date4+
     *
     * return array
     *
     * result will be weeks
     */
    public function CompareDatesandGetWeeksAccommodation(): array
    {
        $multiply['summer'] = 0 ;

        if (!($this->getProgramStartDateFromFrontend() > $this->getSummerDateFromDbAccommodation())
            && !($this->getFrontEndDate() < $this->getSummerStartDateAccommodation())
        )
        {
            if ($this->getFrontEndDate() >= $this->getSummerDateFromDbAccommodation()
                && $this->getProgramStartDateFromFrontend() <= $this->getSummerStartDateAccommodation()
            ){
                $multiply['which'] = 33;
                $multiply['summer'] =
                    $this->compare_between_two_dates($this->getSummerStartDateAccommodation(), $this->getSummerDateFromDbAccommodation());
            } elseif (($this->getFrontEndDate() < $this->getSummerDateFromDbAccommodation()
                && $this->getSummerStartDateAccommodation() > $this->getProgramStartDateFromFrontend()
            )
            ){
                $multiply['which'] = 222;
                $multiply['summer'] =
                    $this->getFrontEndDate() < $this->getSummerDateFromDbAccommodation() ?  $this->compare_between_two_dates($this->getFrontEndDate(), $this->getSummerStartDateAccommodation()) :
                        $this->compare_between_two_dates($this->getFrontEndDate(), $this->getSummerDateFromDbAccommodation());
            } elseif ($this->getFrontEndDate() <= $this->getSummerDateFromDbAccommodation() &&
                $this->getFrontEndDate() >= $this->getSummerStartDateAccommodation()
            ) {
                $multiply['which'] = 2;
                $multiply['summer'] = $this->compare_between_two_dates($this->getProgramStartDateFromFrontend(), $this->getFrontEndDate());
            } elseif ($this->getFrontEndDate() >= $this->getSummerDateFromDbAccommodation() &&
                $this->getProgramStartDateFromFrontend() >= $this->getSummerStartDateAccommodation()){
                $multiply['which'] = 3;
                $multiply['summer'] = $this->compare_between_two_dates($this->getProgramStartDateFromFrontend(), $this->getSummerDateFromDbAccommodation());
            }
        }

        $multiply['which'] = 'null';
        $multiply['peak'] = 0;
        if (!($this->getProgramStartDateFromFrontend() > $this->getPeakDateFromDbAccommodation())
            && !($this->getFrontEndDate() < $this->getPeakStartDateAccommodation())
        )
        {
            if ($this->getFrontEndDate() >= $this->getPeakDateFromDbAccommodation()
                && $this->getProgramStartDateFromFrontend() <= $this->getPeakStartDateAccommodation()
            ) {
                $multiply['which'] = 33;
                $multiply['peak'] =
                    $this->compare_between_two_dates($this->getPeakStartDateAccommodation(), $this->getPeakDateFromDbAccommodation());
            } elseif (($this->getFrontEndDate() < $this->getPeakDateFromDbAccommodation()
                && $this->getPeakStartDateAccommodation() > $this->getProgramStartDateFromFrontend())) {
                $multiply['which'] = 222;
                $multiply['peak'] =
                    $this->getFrontEndDate() < $this->getPeakDateFromDbAccommodation() ?  $this->compare_between_two_dates($this->getFrontEndDate(), $this->getPeakStartDateAccommodation()) :
                        $this->compare_between_two_dates($this->getFrontEndDate(), $this->getPeakDateFromDbAccommodation());
            } elseif ($this->getFrontEndDate() <= $this->getPeakDateFromDbAccommodation() &&
                $this->getFrontEndDate() >= $this->getPeakStartDateAccommodation()) {
                $multiply['which'] = 2;
                $multiply['peak'] =
                    $this->compare_between_two_dates($this->getProgramStartDateFromFrontend(), $this->getFrontEndDate());
            } elseif ($this->getFrontEndDate() >= $this->getPeakDateFromDbAccommodation() &&
                $this->getProgramStartDateFromFrontend() >= $this->getPeakStartDateAccommodation()){
                $multiply['which'] = 3;
                $multiply['peak'] =
                    $this->compare_between_two_dates($this->getProgramStartDateFromFrontend(), $this->getPeakDateFromDbAccommodation());
            }
        }

        $multiply['christmas'] = 0;
        if (!($this->getProgramStartDateFromFrontend() > $this->christmas_end_date)
            && !($this->getFrontEndDate() < $this->christmas_start_date)
        )
        {
            if ($this->getFrontEndDate() >= $this->christmas_end_date
                && $this->getProgramStartDateFromFrontend() <= $this->christmas_start_date
            ) {
                $multiply['which'] = 33;
                $multiply['christmas'] = $this->compare_between_two_dates($this->christmas_start_date, $this->christmas_end_date);
            } elseif (($this->getFrontEndDate() < $this->christmas_end_date
                && $this->christmas_start_date > $this->getProgramStartDateFromFrontend()
            )) {
                $multiply['which'] = 222;
                $multiply['christmas'] = $this->getFrontEndDate() < $this->christmas_end_date ?  $this->compare_between_two_dates($this->getFrontEndDate(), $this->christmas_start_date) :
                        $this->compare_between_two_dates($this->getFrontEndDate(), $this->christmas_end_date);
            } elseif ($this->getFrontEndDate() <= $this->christmas_end_date &&
                $this->getFrontEndDate() >= $this->christmas_start_date
            ){ 
                $multiply['which'] = 2;
                $multiply['christmas'] = $this->compare_between_two_dates($this->getProgramStartDateFromFrontend(), $this->getFrontEndDate());
            } elseif ($this->getFrontEndDate() >= $this->christmas_end_date &&
                $this->getProgramStartDateFromFrontend() >= $this->christmas_start_date) {
                $multiply['which'] = 3;
                $multiply['christmas'] = $this->compare_between_two_dates($this->getProgramStartDateFromFrontend(), $this->christmas_end_date);
            }
        }

        return $multiply;
    }
}