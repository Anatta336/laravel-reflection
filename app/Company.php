<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Eloquent Model to represent companies.
 *
 * @package Company
 */
class Company extends Model
{
    /**
     * @var array Fields that cannot be mass assigned.
     */
    protected $guarded = ['id'];

    /**
     * Defines the has-many relationship with employees.
     *
     * @return Relation
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id', 'id');
    }
}
