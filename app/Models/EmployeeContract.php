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
    public function designation()
    {
        return $this->belongsTo(Designation::class);
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
    public function is_student()
    {
        return $this->employment_type->id == 5;
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

    function DailyRate($yearmonth)
    {
        $daily_rate = 0;
        $monthdays = Carbon::parse($yearmonth)->daysInMonth;

        if ($this->employment_type->rate_type == 'daily') {
            $daily_rate = $this->salary_kes;
        } else {
            $daily_rate = $this->salary_kes / $monthdays;
        }

        return $daily_rate;
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
    function extra_works()
    {
        $extras = $this->employee->extra_works;

        $in = [];

        foreach ($extras as $key => $extra) {
            if (Carbon::parse($extra->date)->isBetween($this->start_date, $this->end_date)) {
                array_push($in, $extra);
            }
        }

        return collect($in);
    }

    function netDaysWorked($yearmonth)
    {

        $month = Carbon::parse($yearmonth);
        $periodStart = max(Carbon::parse($this->start_date)->format('Y-m-d'), $month->firstOfMonth()->toDateString());
        $periodEnd = min(Carbon::parse($this->end_date)->format('Y-m-d'), $month->lastOfMonth()->toDateString());

        $daysWorked = 0;

        foreach ($this->attendances() as $key => $attendance) {
            if (Carbon::parse($attendance->date)->isBetween($periodStart, $periodEnd)) {
                $daysWorked++;
            }
        }

        return $daysWorked;
    }

    function EarnedOffDays($yearmonth)
    {
        $offdays = 0;

        if ($this->employment_type->is_penalizable && $this->designation->is_penalizable) {
            $offdays = round($this->weekly_offs * ($this->netDaysWorked($yearmonth) + $this->employee->daysOnLeave($yearmonth)) / (7 - $this->weekly_offs + 1));
        }

        return $offdays;
    }
    function EarnedSalaryKes($yearmonth)
    {
        $salary = 0;
        $offdays = 0;
        $daysWorked = $this->netDaysWorked($yearmonth);
        $daysOnLeave = $this->employee->daysOnLeave($yearmonth);
        $month = Carbon::parse($yearmonth);
        $monthdays = Carbon::parse($yearmonth)->daysInMonth;


        if ($this->employment_type->is_penalizable && $this->designation->is_penalizable) {
            $daily_rate = $this->DailyRate($yearmonth);
            $offdays = $this->EarnedOffDays($yearmonth);

            $salary = $daily_rate  * ($daysWorked + $daysOnLeave + $offdays);
        } else {
            if ($this->employment_type->rate_type == 'daily') {
                $salary = $this->salary_kes * $this->netDaysWorked($yearmonth);
            } else {
                $salary = $this->salary_kes;
            }
        }

        return $salary;
    }
    function EarnedOvertimeKes($yearmonth)
    {
        $extra_rate = 0;
        $daily_rate = $this->DailyRate($yearmonth);

        foreach ($this->extra_works() as $key => $extra) {
            if ($extra->double_shift) {
                $extra_rate += 1;
            } else {
                $extra_rate += 0.5;
            }
        }

        return ($daily_rate * $extra_rate) + $this->getHolidayEarnings($yearmonth);
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

    function getHolidays($yearmonth)
    {
        $days = [];
        $month = Carbon::parse($yearmonth);

        foreach (Holiday::all() as $key => $holiday) {
            if ($this->isActiveOn($holiday->date) && Carbon::parse($holiday->date)->isBetween($month->firstOfMonth()->toDateString(), $month->lastOfMonth()->toDateString())) {
                array_push($days, $holiday);
            }
        }

        return $days;
    }
    function getAttendedHolidays($yearmonth)
    {
        $days = [];

        foreach ($this->getHolidays($yearmonth) as $key => $holiday) {
            if ($this->employee->hasSignedOn($holiday->date)) {
                array_push($days, $holiday);
            }
        }

        return $days;
    }

    function getHolidayEarnings($yearmonth)
    {

        $earning = 0;

        foreach ($this->getHolidays($yearmonth) as $key => $holiday) {
            if ($this->employee->hasSignedOn($holiday->date)) {
                $earning += ($this->employee->ActiveContractOn($holiday->date)->DailyRate(Carbon::parse($holiday->date)->format('Y-m')) * 2);
            } else {
                $earning += $this->employee->ActiveContractOn($holiday->date)->employment_type->is_penalizable && $this->designation->is_penalizable ? $this->employee->ActiveContractOn($holiday->date)->DailyRate(Carbon::parse($holiday->date)->format('Y-m')) : 0;
            }
        }
        return $this->employment_type->is_penalizable ? ($this->employee->designation->is_penalizable ? $earning : 0) : 0;
    }
}
