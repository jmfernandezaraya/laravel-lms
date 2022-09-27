<?php

namespace App\Models;

use App\Classes\BindsDynamically;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCustodian extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'unique_id';
    protected $casts = [
        'age_range' => 'array',
    ];
    
    protected $table = 'course_custodians';

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
}