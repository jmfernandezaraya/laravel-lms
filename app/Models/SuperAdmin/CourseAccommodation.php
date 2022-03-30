<?php

namespace App\Models\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAccommodation extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $casts = [
        'age_range' => 'array',
        'accommodation_under_age' => 'array',
        'custodian_age_range' => 'array'
    ];

    protected $primaryKey = 'unique_id';

    protected $table = 'course_accommodations';

    public function save_model($db1, $db2, $input1, $input2) {
        $db = \DB::transaction(function() use ($db1, $db2, $input1, $input2) {
            $db1->fill($input1)->save();
            $save1 = $db2->fill($input2)->save();
            if ($save1)
                return true;
        });

        if ($db) {
            \Session::forget(['input1', 'input2', 'db1', 'db2']);
            return true;
        }
    }

    public function course()
    {
        return $this->belongsTo('App\Models\SuperAdmin\Course', 'course_unique_id', 'unique_id');
    }

    public function AccommodationUnderAge()
    {
        return $this->hasOne('App\Models\SuperAdmin\CourseAccommodationUnderAge', 'accom_id', 'unique_id');
    }

    public function AccommodationUnderAges()
    {
        return $this->hasMany('App\Models\SuperAdmin\CourseAccommodationUnderAge', 'accom_id', 'unique_id');
    }

    public function getUnderAge()
    {
        $under_age_gets = $this->AccommodationUnderAges()->get();

        $under_age = [];
        foreach ($under_age_gets as $under_age_get) {
            $under_age[] = $under_age_get->under_age;
        }

        $under_age =  call_user_func_array('array_merge', $under_age) ;

        return $under_age;
    }

    public function getUnderAgeFees($array)
    {
        $underagefees = $this->AccommodationUnderAges()->where('under_age', 'LIKE', '%'.  $array. '%')->first();

        return $underagefees->under_age_fees;
    }
}