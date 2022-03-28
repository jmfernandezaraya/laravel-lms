<?php

namespace App\Traits;

use App\Models\SuperAdmin\School;

/**
 * Trait CityCountryStateTrait
 * @package App\Traits
 */
trait CityCountryStateTrait
{

    /**
     * @var
     */
    /**
     * @var
     */
    /**
     * @var
     */
    private $city, $country, $branch;



    /**
     * @return $this
     */
    public function getCityCountryState()
    {


        $this->city = $this->where('name', $this->name)->pluck('city')->toArray();
        $this->city = array_unique(array_filter($this->city));
        $this->country = $this->where('name', $this->name)->pluck('country')->toArray();
        $this->country = array_unique(array_filter($this->country));
        $this->branch = $this->where('name', $this->name)->pluck('branch_name')->toArray();
        $this->branch = array_unique(array_filter($this->branch));
        if(!empty($this->branch)){

            $this->branch = $this->branch[0];
        }

        return $this;

    }
    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city ?? [];
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country ?? [];
    }

    /**
     * @return mixed
     */
    public function getBranch()
    {
        return  $this->branch  ?? [];
    }

    /**
     * @return $this
     */
    public function IndividualgetCityCountryState()
    {


        $this->city = $this->where('name', $this->name)->pluck('city');

        $this->country = $this->where('name', $this->name)->pluck('country');

        $this->branch = $this->where('name', $this->name)->pluck('branch_name');


        return $this;

    }

    /**
     * @return $this
     */
    public function getCityCountryStatewithCommas()
    {


        $this->city = implode(", ", $this->where('name', $this->name)->pluck('city')->toArray());
        $this->country = implode(", ", $this->where('name', $this->name)->pluck('country')->toArray());
        $this->branch = implode(", ", $this->where('name', $this->name)->pluck('branch_name')->toArray());

        return $this;

    }

    /**
     * @param $countries
     * @return mixed
     */
    public function getCityByCountry($countries)
    {
        return $this->where('country', $countries)->first()['city'];
    }

    /**
     * @param $countries
     * @return mixed
     */
    public function getBranchByCity($countries)
    {
        return $this->where('country', $countries)->first()['branch'];
    }


    /**
     * @return $this
     */
    public function getCityCountryStateAuth()
    {


        $this->city = $this->where('name', $this->name)->whereIn('branch_name', auth('branch_admin')->user()->branch)->pluck('city')->toArray();
        $this->city = array_unique(array_filter($this->city));
        $this->country = $this->where('name', $this->name)->whereIn('branch_name', auth('branch_admin')->user()->branch)->pluck('country')->toArray();
        $this->country = array_unique(array_filter($this->country));
        $this->branch = $this->where('name', $this->name)->whereIn('branch_name', auth('branch_admin')->user()->branch)->pluck('branch_name')->toArray();
        $this->branch = array_unique(array_filter($this->branch));

        return $this;

    }

}
