<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
    public function designations()
    {
        return $this->hasMany(Designation::class);
    }

    public function getEmployeesAttribute()
    {
        $employees = [];

        foreach ($this->designations as $designation) {
            foreach ($designation->employees as $employee) {
                array_push($employees, $employee);
            }
        }

        return $employees;
    }
}
