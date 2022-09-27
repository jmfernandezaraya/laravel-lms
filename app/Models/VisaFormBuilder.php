<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaFormBuilder extends Model
{
    use HasFactory;

    protected $casts = ['form_builder_value' => 'json'];
    protected $guarded = [];

    public function belongsTo()
    {
        return $this->belongsTo(VisaForm::class);
    }
}