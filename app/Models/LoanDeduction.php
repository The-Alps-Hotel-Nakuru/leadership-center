<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanDeduction extends Model
{
    use HasFactory;

    function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    function employee()
    {
        return $this->hasOneThrough(EmployeesDetail::class, Loan::class, 'employees_detail_id', 'id', 'loan_id', 'id');
    }

    function getIsSettledAttribute()
    {
        $payroll = Payroll::where('year', $this->year)->where('month', $this->month);

        if ($payroll->exists() && count($payroll->first()->payments) > 0) {
            return true;
        }

        return false;
    }
}
