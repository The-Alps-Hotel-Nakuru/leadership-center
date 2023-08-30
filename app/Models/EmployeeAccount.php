<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAccount extends Model
{
    use HasFactory;

    public function bank() {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
    public function employee() {
        return $this->belongsTo(EmployeesDetail::class, 'employees_detail_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
