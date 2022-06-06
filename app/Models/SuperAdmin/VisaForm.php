<?php

namespace App\Models\SuperAdmin;

use App\Models\Formbuilder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VisaForm
 * @package App\Models\SuperAdmin
 */
class VisaForm extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getNationality()
    {
        return $this->belongsTo(AddNationality::class, 'nationality', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formBuilders()
    {
        return $this->hasMany(VisaFormBuilder::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function visaOtherFee()
    {
        return $this->hasOne(VisaFormOtherVisaFee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visaOtherFees()
    {
        return $this->hasMany(VisaFormOtherVisaFee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function visaServiceFee()
    {
        return $this->hasOne(VisaFormVisaServiceFee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visaServiceFees()
    {
        return $this->hasMany(VisaFormVisaServiceFee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function applyFrom()
    {
        return $this->belongsTo(ApplyFrom::class, 'applying_from', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function applicationCenter()
    {
        return $this->belongsTo(VisaApplicationCenter::class, 'application_center');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nationalityRelation()
    {
        return $this->belongsTo(AddNationality::class, 'nationality');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function whereToTravel()
    {
        return $this->belongsTo(AddWhereToTravel::class, 'to_travel');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function TypeOfVisa()
    {
        return $this->belongsTo(AddTypeOfVisa::class, 'type_of_visa');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function formBuilder()
    {
        return $this->hasOne(Formbuilder::class);
    }
}