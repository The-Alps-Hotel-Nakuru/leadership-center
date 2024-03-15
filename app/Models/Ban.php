<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    use HasFactory;

    function employee() {
        return $this->belongsTo(EmployeesDetail::class, 'employees_detail_id');
    }
}
