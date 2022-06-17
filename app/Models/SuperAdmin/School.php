<?php

namespace App\Models\SuperAdmin;

use App\Traits\StorageTrait;

use Ghanem\Rating\Traits\Ratingable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class School extends Model
{
    use HasFactory;
    use Ratingable, StorageTrait;

    protected $guarded = [];
    protected $casts = [
        'branch' => 'array',
        'logos' => 'array',
        'multiple_photos' => 'array',
        'video' => 'array',
        'video_url' => 'array',
    ];

    public function save_model($db1, $db2, $input1, $input2)
    {
        $db = \DB::transaction(function () use ($db1, $db2, $input1, $input2) {
            $db1->fill($input1)->save();
            $save1 = $db2->fill($input2)->save();
            if ($save1) {
                return true;
            }
        });

        if ($db) {
            return true;
        }
        return false;
    }

    public function userSchools()
    {
        return $this->hasMany(UserSchool::class);
    }

    public function userSchool()
    {
        return $this->hasOne(UserSchool::class);
    }

    public function country()
    {
        return $this->hasOne(\App\Models\Country::class, 'id', 'country_id');
    }

    public function city()
    {
        return $this->hasOne(\App\Models\City::class, 'id', 'city_id');
    }

    public function name()
    {
        return $this->hasOne(\App\Models\SchoolName::class, 'id', 'name_id');
    }

    public function nationalities()
    {
        return $this->hasMany(SchoolNationality::class, 'school_id', 'id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'school_id', 'id');
    }

    public function availableCourses()
    {
        return $this->hasMany(Course::class, 'school_id', 'id')->with('coursePrograms')->where('display', true)->where('deleted', false);
    }

    public function getLogoAttribute($value)
    {
        return asset('storage/app/public/school_images/' . $value);
    }

    public function courseApplicationDetails()
    {
        return $this->hasMany(\App\Models\CourseApplication::class, 'school_id', 'id');
    }

    public function delete()
    {
        if (!empty($this->logo)) {
            $logo = explode("school_images/", $this->logo);
            if (isset($logo[1])) {
                Storage::delete('public/school_images/' . $logo[1]);
            }
        }

        if (!empty($this->video)) {
            if (is_array($this->video)) {
                foreach ($this->video as $videos) {
                    Storage::delete('public/video/' . $videos);
                }
            } else {
                Storage::delete('public/video/' . $this->video);
            }
        }

        if (!empty($this->logos)) {
            if (is_array($this->logos)) {
                foreach ($this->logos as $videos) {
                    Storage::delete('public/school_images/' . $videos);
                }
            } else {
                Storage::delete('public/school_images/' . $this->logos);
            }
        }

        if (!empty($this->multiple_photos)) {
            if (is_array($this->multiple_photos)) {
                foreach ($this->multiple_photos as $videos) {
                    Storage::delete('public/school_images/' . $videos);
                }
            } else {
                Storage::delete('public/school_images/' . $this->multiple_photos);
            }
        }
        $this->courses()->delete();
        return parent::delete();
    }
}