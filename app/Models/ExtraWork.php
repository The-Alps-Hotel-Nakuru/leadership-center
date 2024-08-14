<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraWork extends Model
{
    use HasFactory;
    public function employee()
    {
        return $this->hasOne(EmployeesDetail::class, 'id', 'employees_detail_id');
    }
    function getIsPaidAttribute()
    {
        $payroll = Payroll::where('year', Carbon::parse($this->date)->format('Y'))->where('month', Carbon::parse($this->date)->format('m'))->get();
        if ($payroll && $payroll->is_paid) {
            return true;
        }
        return false;
    }
}
