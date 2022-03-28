<?php

namespace App\Models\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMedicalFee extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'unique_id';

    protected $table = 'course_medical_fees';

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

    public function medical()
    {
        return $this->belongsTo('App\Models\SuperAdmin\CourseMedical', 'unique_id', 'course_medical_unique_id');
    }
}