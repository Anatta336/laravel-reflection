<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = ['id'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id', 'id');
    }
}
