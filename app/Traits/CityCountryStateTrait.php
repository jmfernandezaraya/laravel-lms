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
    private $city, $country, $branch;

    /**
     * @return $this
     */
    public function getCityCountryState()
    {
        if (app()->getLocale() == 'en') {
            $this->city = $this->where('name', $this->name)->pluck('city')->toArray();
            $this->city = array_unique(array_filter($this->city));
            $this->country = $this->where('name', $this->name)->pluck('country')->toArray();
            $this->country = array_unique(array_filter($this->country));
            $this->branch = $this->where('name', $this->name)->pluck('branch_name')->toArray();
            $this->branch = array_unique(array_filter($this->branch));
        } else if (app()->getLocale() == 'ar') {
            $this->city = $this->where('name', $this->name)->pluck('city_ar')->toArray();
            $this->city = array_unique(array_filter($this->city));
            $this->country = $this->where('name', $this->name)->pluck('country_ar')->toArray();
            $this->country = array_unique(array_filter($this->country));
            $this->branch = $this->where('name', $this->name)->pluck('branch_name_ar')->toArray();
            $this->branch = array_unique(array_filter($this->branch));
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
        return $this->branch  ?? [];
    }

    /**
     * @param $school
     * @return mixed
     */
    public function getCountries()
    {
        if (app()->getLocale() == 'en') {
            return $this->where('name', $this->name)->distinct()->pluck('country')->toArray();
        } else {
            return $this->where('name_ar', $this->name)->distinct()->pluck('country_ar')->toArray();
        }
    }

    /**
     * @param $country
     * @return mixed
     */
    public function getCitiesByCountry($country)
    {
        if (app()->getLocale() == 'en') {
            return $this->where('name', $this->name)->where('country', $country)->distinct()->pluck('city')->toArray();
        } else {
            return $this->where('name_ar', $this->name)->where('country_ar', $country)->distinct()->pluck('city_ar')->toArray();
        }
    }

    /**
     * @param $country, $city
     * @return mixed
     */
    public function getBranchesByCountryCity($country, $city)
    {
        if (app()->getLocale() == 'en') {
            return $this->where('name', $this->name)->where('country', $country)->where('city', $city)->distinct()->pluck('branch_name')->toArray();
        } else {
            return $this->where('name_ar', $this->name)->where('country_ar', $country)->where('city_ar', $city)->distinct()->pluck('branch_name_ar')->toArray();
        }
    }

    /**
     * @return $this
     */
    public function IndividualgetCityCountryState()
    {
        $this->city = $this->where('name', $this->name)->distinct()->pluck('city');
        $this->country = $this->where('name', $this->name)->distinct()->pluck('country');
        $this->branch = $this->where('name', $this->name)->distinct()->pluck('branch_name');

        return $this;
    }

    /**
     * @return $this
     */
    public function getCityCountryStatewithCommas()
    {
        $this->city = implode(", ", $this->where('name', $this->name)->distinct()->pluck('city')->toArray());
        $this->country = implode(", ", $this->where('name', $this->name)->distinct()->pluck('country')->toArray());
        $this->branch = implode(", ", $this->where('name', $this->name)->distinct()->pluck('branch_name')->toArray());

        return $this;
    }

    /**
     * @param $countries
     * @return mixed
     */
    public function getCityByCountries($countries)
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