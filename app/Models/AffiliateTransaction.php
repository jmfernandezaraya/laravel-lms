<?php

namespace App\Models;

use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AffiliateTransaction
 * @package App\Models\SuperAdmin
 */
class AffiliateTransaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function affiliate()
    {
        return $this->belongsTo(User::class, 'affiliate_id', 'id');
    }

    /**
     * @return int|mixed
     */
    public function getTransactionRefunded()
    {
        return $this->query()->whereNotNull('amount_refunded')->sum('amount_refunded');
    }

    /**
     * @return int|mixed
     */
    public function getTransactionAdded()
    {
        return $this->query()->whereNotNull('amount_added')->sum('amount_added');
    }
}