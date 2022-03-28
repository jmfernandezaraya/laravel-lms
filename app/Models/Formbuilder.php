<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formbuilder extends Model
{
    use HasFactory;
    protected $table = 'form_builders';

    protected $fillable = ['form_name', 'form_data', 'active', 'visa_form_id'];
}
