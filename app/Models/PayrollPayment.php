<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollPayment extends Model
{
    use HasFactory;

    protected $appends = [
        'deductions',
        'additions',
        'net_pay'
    ];

    public function employee()
    {
        return $this->hasOne(EmployeesDetail::class, 'id', 'employees_detail_id');
    }

    function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function payroll()
    {
        return $this->hasOne(Payroll::class, 'id', 'payroll_id');
    }

    function getDeductionsAttribute()
    {
        return $this->nssf + $this-> nhif + $this->shif + $this->paye + $this->housing_levy + $this->total_fines + $this->total_loans + $this->total_advances + $this->total_welfare_contributions + $this->attendance_penalty;
    }

    function getAdditionsAttribute()
    {
        return $this->total_bonuses + $this->total_overtimes;
    }

    public function getNetPayAttribute()
    {
        return $this->gross_salary - $this->deductions + $this->additions;
    }
}
