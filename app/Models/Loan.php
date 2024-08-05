<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    function employee()
    {
        return $this->belongsTo(EmployeesDetail::class, 'employees_detail_id');
    }

    function loan_deductions()
    {
        return $this->hasMany(LoanDeduction::class);
    }

    function hasBeganSettlement(){
        foreach ($this->loan_deductions as $key => $deduction) {
            if ($deduction->is_settled) {
                return true;
            }
        }

        return false;
    }

    function getTotalAmountAttribute()
    {
        $t = 0;

        foreach ($this->loan_deductions as $key => $deduction) {
            $t += $deduction->amount;
        }

        return $t;
    }

    function getBalanceAttribute(){
        $balance = $this->amount;

        foreach ($this->loan_deductions as $key => $deduction) {
            if ($deduction->is_settled) {
                $balance -= $deduction->amount;
            }
        }

        return $balance;

    }
}
