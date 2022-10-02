<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeesDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function contracts()
    {
        return $this->hasMany(EmployeeContract::class);
    }


    public function getHasActiveContractAttribute()
    {
        foreach ($this->contracts as $contract) {
            if ($contract->is_active) {
                return true;
            }
        }
        return false;
    }
}
