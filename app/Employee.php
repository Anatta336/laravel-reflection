<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Eloquent model for the employees.
 *
 * @package Employee
 */
class Employee extends Model
{
    /**
     * @var array Fields that cannot be mass assigned.
     */
    protected $guarded = ['id'];

    /**
     * Defines the belongs-to relationship from an employee to a company.
     *
     * @return Relation
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
