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

    public function payroll()
    {
        return $this->hasOne(Payroll::class, 'id', 'payroll_id');
    }

    function getDeductionsAttribute()
    {
        return $this->nssf + $this->nhif + $this->paye + $this->housing_levy + $this->total_fines + $this->total_advances + $this->total_welfare_contributions;
    }

    function getAdditionsAttribute()
    {
        return $this->tax_rebate + $this->total_bonuses;
    }

    public function getNetPayAttribute()
    {
        return $this->gross_salary - $this->deductions + $this->additions;
    }
}
