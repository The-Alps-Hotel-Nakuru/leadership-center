<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WelfareContribution extends Model
{
    use HasFactory;

    public function employee()
    {
        return $this->belongsTo(EmployeesDetail::class, 'employees_detail_id');
    }
}
