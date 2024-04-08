<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeContract extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $appends = [
        'is_active'
    ];


    public function getIsActiveAttribute()
    {
        return Carbon::now()->lessThan($this->end_date);
    }


    public function employee()
    {
        return $this->hasOne(EmployeesDetail::class, 'id', 'employees_detail_id');
    }

    public function user()
    {
        return $this->through('employee')->has('user');
    }

    public function employment_type()
    {
        return $this->belongsTo(EmploymentType::class);
    }

    public function is_casual()
    {
        return $this->employment_type->id == 1;
    }
    public function is_full_time()
    {
        return $this->employment_type->id == 2;
    }
    public function is_intern()
    {
        return $this->employment_type->id == 3;
    }
    public function is_external()
    {
        return $this->employment_type->id == 4;
    }

    public function terminate()
    {
        $this->end_date = Carbon::now()->toDateString();
        $this->save();
    }
    public function terminateOn($date)
    {
        $this->end_date = Carbon::parse($date)->toDateString();
        $this->save();
    }


    public function getHouseAllowanceAttribute()
    {
        if ($this->employment_type_id == 2) {
            return $this->salary_kes * 0.15;
        }
        return 0;
    }

    public function isActiveDuring($date1, $date2)
    {
        if (Carbon::parse($date1)->isBetween($this->start_date, $this->end_date)) {
            return true;
        } elseif (Carbon::parse($date2)->isBetween($this->start_date, $this->end_date)) {
            return true;
        } elseif (Carbon::parse($this->start_date)->isBetween($date1, $date2)) {
            return true;
        } elseif (Carbon::parse($this->end_date)->isBetween($date1, $date2)) {
            return true;
        } else {
            return false;
        }
    }

    public function isActiveOn($date)
    {
        return Carbon::parse($date)->isBetween($this->start_date, $this->end_date);
    }

    function attendances()
    {
        $attendances = $this->employee->attendances;

        $in = [];

        foreach ($attendances as $key => $attendance) {
            if (Carbon::parse($attendance->date)->isBetween($this->start_date, $this->end_date)) {
                array_push($in, $attendance);
            }
        }

        return collect($in);
    }

    function payrolls()
    {
        $usedPayrolls = [];
        $payrolls = Payroll::all();
        foreach ($payrolls as $key => $payroll) {
            $first = Carbon::parse($payroll->year . '-' . $payroll->month)->firstOfMonth();
            $last = Carbon::parse($payroll->year . '-' . $payroll->month)->lastOfMonth();
            if ($this->isActiveDuring($first, $last)) {
                array_push($usedPayrolls, $payroll);
            }
        }

        return $usedPayrolls;
    }
}
