<?php

namespace App\Models;

use App\Classes\BindsDynamically;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAirport extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'unique_id';
    
    protected $table = 'course_airports';

    public function save_model($db1, $db2, $input1, $input2) {
        $db = \DB::transaction(function() use ($db1, $db2, $input1, $input2) {
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

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'unique_id', 'course_unique_id');
    }

    public function fees()
    {
        return $this->hasMany('App\Models\CourseAirportFee', 'course_airport_unique_id', 'unique_id')->orderBy('unique_id', 'asc');
    }
}