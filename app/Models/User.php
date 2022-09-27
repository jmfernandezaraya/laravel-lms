<?php

namespace App\Models;

use App\Classes\BindsDynamically;

use App\Models\LikedSchool;
use App\Models\SchoolAdminCourseEditPermissions;
use App\Models\UserSchool;
use App\Models\UserPermission;
use App\Models\AffiliateTransaction;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, BindsDynamically;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'created_at',
        'updated_at',
        'email_verified',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'school_ids' => 'array',
        'country_ids' => 'array',
        'city_ids' => 'array',
        'branch' => 'array',
        'branch_ar' => 'array',
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param $image
     */
    public static function delete_images($image)
    {
        Storage::delete('public/school_admin_images/' . $image);
    }

    /**
     * @param $db1
     * @param $db2
     * @param $input1
     * @param $input2
     * @return bool
     */
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
            \Session::forget(['input1', 'input2', 'db1', 'db2']);
            return true;
        }
    }

    /**
     * @return bool
     */
    public function isSchoolAdmin()
    {
        return $this->user_type == 'school_admin' ? true : false;
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->user_type == 'super_admin' ? true : false;
    }

    /**
     * @return bool
     */
    public function isBranchAdmin()
    {
        return $this->user_type == 'branch_admin' ? true : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function likedSchool()
    {
        return $this->hasOne(LikedSchool::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userSchool()
    {
        return $this->hasOne(UserSchool::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userSchools()
    {
        return $this->hasMany(UserSchool::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function editCoursePermission()
    {
        return $this->hasOne(SchoolAdminCourseEditPermissions::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function permission()
    {
        return $this->hasOne(UserPermission::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transactions()
    {
        return $this->hasMany(AffiliateTransaction::class, 'affiliate_id');
    }    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseApplicationDetails()
    {
        return $this->hasMany(CourseApplication::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function updateCourseApplication()
    {
        return $this->hasMany(CourseApplication::class, 'user_id')->latest()->where('paid',  0)->orWhere('paid', 2);
    }
}