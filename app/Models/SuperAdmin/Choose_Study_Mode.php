<?php

namespace App\Models\SuperAdmin;

use App\Classes\BindsDynamically;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choose_Study_Mode extends Model
{
    use HasFactory;
    use BindsDynamically;

    public function __construct()
    {
        $this->setTable('choose_study_modes_' . get_language());
    }

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
}
