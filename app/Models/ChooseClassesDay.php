<?php

namespace App\Models;

use App\Classes\BindsDynamically;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChooseClassesDay extends Model
{
    use HasFactory;

    protected $primaryKey = 'unique_id';
}