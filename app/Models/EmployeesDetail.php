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

    function ban()
    {
        return $this->hasOne(Ban::class, 'employees_detail_id', 'id' );
    }

    function getIsBannedAttribute()
    {
        return $this->ban != null;
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function welfareContributions()
    {
        return $this->hasMany(WelfareContribution::class);
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
            if ($contract->isActiveDuring(Carbon::parse($yearmonth)->firstOfMonth(), Carbon::parse($yearmonth)->lastOfMonth())) {
                return EmployeeContract::find($contract->id);
            }
        }
    }
    public function ActiveContractOn($date)
    {
        foreach ($this->contracts as $contract) {
            if ($contract->isActiveOn(Carbon::parse($date)->toDateString())) {
                return EmployeeContract::find($contract->id);
            }
        }
    }
    public function ActiveContractBetween($date1, $date2)
    {
        foreach ($this->contracts as $contract) {
            if ($contract->isActiveDuring(Carbon::parse($date1)->toDateString(), Carbon::parse($date2)->toDateString())) {
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
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function getAttendedDatesAttribute()
    {
        $dates = [];
        foreach ($this->attendances as $item) {
            array_push($dates, Carbon::parse($item->date)->format('Y-m-d'));
        }

        return $dates;
    }
    public function getLeaveDatesAttribute()
    {
        $dates = [];
        foreach ($this->leaves as $item) {
            $start = Carbon::parse($item->start_date);
            $end = Carbon::parse($item->end_date);
            while ($start->lessThanOrEqualTo($end)) {
                array_push($dates, $start->format('Y-m-d'));
                $start->addDay();
            }
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
    public function daysOnLeave($yearmonth)
    {
        $count = 0;

        foreach ($this->leave_dates as $date) {
            if (Carbon::parse($date)->format('Y-m') == Carbon::parse($yearmonth)->format('Y-m')) {
                $count += 1;
            }
        }

        return $count;
    }

    public function hasSignedInToday()
    {
        return in_array(Carbon::now()->format('Y-m-d'), $this->attended_dates);
    }

    public function hasSignedOn($date)
    {
        return in_array(Carbon::parse($date)->format('Y-m-d'), $this->attended_dates);
    }
    public function onLeaveToday()
    {
        return in_array(Carbon::now()->format('Y-m-d'), $this->leave_dates);
    }

    public function onLeaveOn($date)
    {
        return in_array(Carbon::parse($date)->format('Y-m-d'), $this->leave_dates);
    }

    public function onLeaveBetween($date1, $date2)
    {
        return $this->leaves()
            ->where('start_date', '<=', $date2)
            ->where('end_date', '>=', $date1)
            ->exists();
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

    public function isCasualBetween($date1, $date2)
    {
        foreach ($this->contracts as $contract) {
            if ($contract->isActiveDuring(Carbon::parse($date1)->toDateString(), Carbon::parse($date2)->toDateString())) {
                $contract = EmployeeContract::find($contract->id);
                if ($contract->employment_type_id == 1) {
                    return true;
                }
            }
        }
        return false;
    }
    public function isFullTimeBetween($date1, $date2)
    {
        foreach ($this->contracts as $contract) {
            if ($contract->isActiveDuring(Carbon::parse($date1)->toDateString(), Carbon::parse($date2)->toDateString())) {
                $contract = EmployeeContract::find($contract->id);
                if ($contract->employment_type_id == 2) {
                    return true;
                }
            }
        }
        return false;
    }
    public function isInternBetween($date1, $date2)
    {
        foreach ($this->contracts as $contract) {
            if ($contract->isActiveDuring(Carbon::parse($date1)->toDateString(), Carbon::parse($date2)->toDateString())) {
                $contract = EmployeeContract::find($contract->id);
                if ($contract->employment_type_id == 3) {
                    return true;
                }
            }
        }
        return false;
    }
    public function isExternalBetween($date1, $date2)
    {
        foreach ($this->contracts as $contract) {
            if ($contract->isActiveDuring(Carbon::parse($date1)->toDateString(), Carbon::parse($date2)->toDateString())) {
                $contract = EmployeeContract::find($contract->id);
                if ($contract->employment_type_id == 4) {
                    return true;
                }
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
    public function getIsInternAttribute()
    {
        if ($this->has_active_contract) {
            if ($this->active_contract->employment_type_id == 3) {
                return true;
            }
        }
        return false;
    }

    public function monthlySalaries()
    {
        return $this->hasMany(MonthlySalary::class);
    }

    public function advances()
    {
        return $this->hasMany(Advance::class);
    }
    public function bonuses()
    {
        return $this->hasMany(Bonus::class);
    }
    public function fines()
    {
        return $this->hasMany(Fine::class);
    }
    public function bankAccount()
    {
        return $this->hasOne(EmployeeAccount::class, 'employees_detail_id', 'id');
    }
}
