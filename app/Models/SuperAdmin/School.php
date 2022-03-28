<?php

namespace App\Models\SuperAdmin;
use App\Traits\CityCountryStateTrait;
use App\Traits\StorageTrait;
use Ghanem\Rating\Traits\Ratingable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class School extends Model
{
    use Ratingable, StorageTrait;
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'logos' => 'array',
        'multiple_photos' => 'array',
        'school_video' => 'array',
        'video_url' => 'array',
        'branch_name' => 'array',
        'branch_name_ar' => 'array',
    ];

    use CityCountryStateTrait;
    public function save_model($db1, $db2, $input1, $input2)
    {
        $db = \DB::transaction(function () use ($db1, $db2, $input1, $input2) {
            $db1->fill($input1)->save();
            $save1 = $db2->fill($input2)->save();
            if ($save1)
                return true;
        });

        if ($db) {
            return true;
        }
        return false;
    }

    public function userSchools()
    {
        return $this->hasMany(UsersSchools::class);
    }

    public function userSchool()
    {
        return $this->hasOne(UsersSchools::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'school_id', 'id');
    }

    public function availableCourses()
    {
        return $this->hasMany(Course::class, 'school_id', 'id')->where('display', true)->where('deleted', false);
    }

    public function getLogoAttribute($value)
    {
        return asset('storage/app/public/school_images/' . $value);
    }

    public function delete()
    {
        if (!empty($this->logo)) {
            $logo = explode("school_images/", $this->logo);
            if (isset($logo[1])) {
                Storage::delete('public/school_images/' . $logo[1]);
            }
        }

        if (!empty($this->school_video)) {
            if (is_array($this->school_video)) {
                foreach ($this->school_video as $videos) {
                    Storage::delete('public/school_video/' . $videos);
                }
            } else {
                Storage::delete('public/school_video/' . $this->school_video);
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