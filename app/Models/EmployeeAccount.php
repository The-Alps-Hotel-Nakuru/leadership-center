<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAccount extends Model
{
    use HasFactory;

    public function bank() {
        return $this->belongsTo(Bank::class);
    }
    public function employee() {
        return $this->hasOne(EmployeesDetail::class, 'id', 'employees_detail_id');
    }


}
