<?php

namespace App\Models\SuperAdmin;

use App\Classes\BindsDynamically;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChooseClassesDay extends Model
{
    use HasFactory;

    protected $primaryKey = 'unique_id';
}