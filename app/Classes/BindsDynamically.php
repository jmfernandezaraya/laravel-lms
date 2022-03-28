<?php

namespace App\Classes;

/**
 * Trait BindsDynamically
 * @package App\Classes
 */
trait BindsDynamically
{
    /**
     * @var null
     */
    protected $table = null;

    /**
     * @param array $attributes
     * @param false $exists
     * @return BindsDynamically|\Illuminate\Database\Eloquent\Model|\Illuminate\Foundation\Auth\User
     */
    public function newInstance($attributes = [], $exists = false)
    {
        // Overridden in order to allow for late table binding.

        $model = parent::newInstance($attributes, $exists);
        $model->setTable($this->table);

        return $model;
    }
}
