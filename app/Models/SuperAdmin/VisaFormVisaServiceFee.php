<?php

namespace App\Models\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaFormVisaServiceFee extends Model
{
    use HasFactory;

    protected $table = 'visa_forms_visa_services_fee';
    protected $guarded = [];

    public function visaForm()
    {
        return $this->belongsTo(VisaForm::class);
    }
}