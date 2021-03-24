<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
