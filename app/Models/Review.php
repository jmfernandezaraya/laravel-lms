<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }

    public function course_applications()
    {
        return $this->belongsTo('App\Models\CourseApplication', 'course_application_id', 'id');
    }

    public function rated()
    {
        return $this->average_point;
    }

    public function schoolTeachingRated()
    {
        $rates = 0;
        if ($this->quality_teaching) $rates = $rates + $this->quality_teaching;
        if ($this->school_facilities) $rates = $rates + $this->school_facilities;
        if ($this->social_activities) $rates = $rates + $this->social_activities;
        if ($this->school_location) $rates = $rates + $this->school_location;
        if ($this->satisfied_teaching) $rates = $rates + $this->satisfied_teaching;

        return $rates / 5;
    }

    public function accommodationRated()
    {
        $rates = 0;
        if ($this->level_cleanliness) $rates = $rates + $this->level_cleanliness;
        if ($this->distance_accommodation_school) $rates = $rates + $this->distance_accommodation_school;
        if ($this->satisfied_accommodation) $rates = $rates + $this->satisfied_accommodation;

        return $rates / 3;
    }

    public function otherRated()
    {
        $rates = 0;
        if ($this->airport_transfer) $rates = $rates + $this->airport_transfer;
        if ($this->city_activities) $rates = $rates + $this->city_activities;

        return $rates / 2;
    }
}