<?php

namespace App\Models\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaFormOtherVisaFee extends Model
{
    use HasFactory;

    protected $table = 'visa_forms_other_visa_fee';
    protected $guarded = [];

    public function visaForm()
    {
        return $this->belongsTo(VisaForm::class);
    }
}