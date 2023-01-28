<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeesDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function contracts()
    {
        return $this->hasMany(EmployeeContract::class);
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->age;
    }

    public function getTitleAttribute()
    {
        if ($this->gender == 'male') {
            return 'Mr.';
        }
        if ($this->gender == 'female') {
            if ($this->marital_status == 'married' || $this->marital_status == 'widowed') {
                return 'Mrs.';
            }
            if ($this->marital_status == 'single' || $this->marital_status == 'divorced') {
                return 'Ms.';
            }
        }
    }


    public function getHasActiveContractAttribute()
    {
        foreach ($this->contracts as $contract) {
            if ($contract->is_active) {
                return true;
            }
        }
        return false;
    }
    public function getActiveContractAttribute()
    {
        foreach ($this->contracts as $contract) {
            if ($contract->is_active) {
                return EmployeeContract::find($contract->id);
            }
        }
    }

    public function ActiveContractDuring($yearmonth)
    {
        foreach ($this->contracts as $contract) {
            if (Carbon::parse($yearmonth)->isBetween($this->start_date, $this->end_date)) {
                return EmployeeContract::find($contract->id);
            }
        }
    }

    public function insurance()
    {
        return $this->hasMany(Insurance::class);
    }


    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function getAttendedDatesAttribute()
    {
        $dates = [];
        foreach ($this->attendances as $item) {
            array_push($dates, Carbon::parse($item->date)->format('Y-m-d'));
        }

        return $dates;
    }


    public function getCurrentMonthNumberAttribute()
    {
        $count = 0;

        foreach ($this->attendances as $attendance) {
            if (Carbon::parse($attendance->date)->format('Y-m') == Carbon::now()->format('Y-m')) {
                $count += 1;
            }
        }

        return $count;
    }
    public function daysWorked($yearmonth)
    {
        $count = 0;

        foreach ($this->attendances as $attendance) {
            if (Carbon::parse($attendance->date)->format('Y-m') == Carbon::parse($yearmonth)->format('Y-m')) {
                $count += 1;
            }
        }

        return $count;
    }

    public function hasSignedInToday()
    {
        return in_array(Carbon::now()->format('Y-m-d'), $this->attended_dates);
    }


    public function getIsCasualAttribute()
    {
        if ($this->has_active_contract) {
            if ($this->active_contract->employment_type_id == 1) {
                return true;
            }
        }
        return false;
    }
    public function getIsFullTimeAttribute()
    {
        if ($this->has_active_contract) {
            if ($this->active_contract->employment_type_id == 2) {
                return true;
            }
        }
        return false;
    }

    public function monthlySalaries()
    {
        return $this->hasMany(MonthlySalary::class);
    }
}
