<?php

namespace App\Models\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\SuperAdmin\Choose_Language;

class CurrencyExchangeRate extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $table = 'currency_exchange_rates';

    public function language()
    {
        return $this->belongsTo(Choose_Language::class, 'language_id', 'unique_id');
    }
}