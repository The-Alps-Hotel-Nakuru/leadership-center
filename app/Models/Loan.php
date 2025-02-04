<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    public function employee()
    {
        return $this->belongsTo(EmployeesDetail::class, 'employees_detail_id');
    }

    public function loan_deductions()
    {
        return $this->hasMany(LoanDeduction::class);
    }

    public function hasBeganSettlement()
    {
        foreach ($this->loan_deductions as $key => $deduction) {
            if ($deduction->is_settled) {
                return true;
            }
        }

        return false;
    }

    public function getTotalAmountAttribute()
    {
        $t = 0;

        foreach ($this->loan_deductions as $key => $deduction) {
            $t += $deduction->amount;
        }

        return $t;
    }

    public function getBalanceAttribute()
    {
        $balance = $this->amount;

        foreach ($this->loan_deductions as $key => $deduction) {
            if (!$deduction->is_settled) {
                $balance -= $deduction->amount;
            }
        }

        return $balance;
    }
    public function getUnsettledBalanceAttribute()
    {
        $balance = $this->amount;

        foreach ($this->loan_deductions as $key => $deduction) {
            $balance -= $deduction->amount;
        }

        return $balance;
    }
}
