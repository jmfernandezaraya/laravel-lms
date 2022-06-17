<?php

namespace App\Models\SuperAdmin;

use App\Models\User;

/**
 * Class BranchSchools
 * @package App\Models\SuperAdmin
 */
class BranchSchools extends UserSchool
{
    /**
     * @var string
     */
    protected $table = 'users_schools';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->where('user_type', 'branch_admin');
    }
}