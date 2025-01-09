<?php

namespace App\Models;

use App\Services\ReversePaymentsCalculationService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeContract extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $appends = [
        'is_active',
        'duration',
    ];


    public function getIsActiveAttribute()
    {

        return Carbon::now()->lessThan($this->end_date ?? 'now');
    }


    public function employee()
    {
        return $this->hasOne(EmployeesDetail::class, 'id', 'employees_detail_id');
    }

    function getDurationAttribute()
    {
        $months = Carbon::parse($this->start_date)->diffInMonths($this->end_date);
        $weeks = Carbon::parse($this->start_date)->diffInWeeks($this->end_date);
        $days = Carbon::parse($this->start_date)->diffInDays($this->end_date);
        $hours = Carbon::parse($this->start_date)->diffInHours($this->end_date);
        $monthsString = Carbon::parse($this->start_date)->diffInMonths($this->end_date) . " months";
        $weeksString = Carbon::parse($this->start_date)->diffInWeeks($this->end_date) . " weeks";
        $daysString = Carbon::parse($this->start_date)->diffInDays($this->end_date) . " days";
        $hoursString = Carbon::parse($this->start_date)->diffInHours($this->end_date) . " hours";

        return $months > 0 ? $monthsString : ($weeks > 0 ? $weeksString : ($days > 0 ? $daysString : $hoursString));
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

        $estimated_gross = 0;


        if ($this->employment_type->rate_type == 'daily') {
            $estimated_gross = $this->salary_kes * $this->netDaysWorked($yearmonth);
        } elseif ($this->employment_type->rate_type == 'monthly') {
            $estimated_gross = $this->salary_kes;
        } else {
            return 0;
        }

        $gross_pay_calculations = new ReversePaymentsCalculationService($estimated_gross);

        if ($this->is_net) {
            if ($this->employment_type->rate_type == 'daily') {
                $daily_rate = $this->netDaysWorked($yearmonth) ? ($gross_pay_calculations->calculateGrossFromNet($yearmonth) / $this->netDaysWorked($yearmonth)) : 0;
            } elseif ($this->employment_type->rate_type == 'monthly') {
                $daily_rate = $gross_pay_calculations->calculateGrossFromNet($yearmonth) / $monthdays;
            }
        } else {
            if ($this->employment_type->rate_type == 'daily') {
                $daily_rate = $this->salary_kes;
            } elseif ($this->employment_type->rate_type == 'monthly') {
                $daily_rate = $this->salary_kes / $monthdays;
            }
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
    public function isActiveAfter($date)
    {
        return Carbon::parse($date)->isBefore($this->start_date) || Carbon::parse($date)->isBefore($this->end_date);
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
        $days = Carbon::parse($yearmonth)->daysInMonth;

        if ($this->employment_type->is_penalizable && $this->designation->is_penalizable) {
            $offdays = ceil($this->weekly_offs * ($this->netDaysWorked($yearmonth) + $this->employee->daysOnLeave($yearmonth)) / (7 - $this->weekly_offs));
        }

        return $days == 31 ? $offdays : $offdays - 1;
    }

    function daysActive($yearmonth)
    {
        // Parse the year and month
        $month = Carbon::parse($yearmonth);
        $startOfMonth = $month->startOfMonth()->toDateString();
        $endOfMonth = $month->endOfMonth()->toDateString();


        // Get the contract start and end dates
        $contractStart = Carbon::parse($this->start_date)->toDateString();
        $contractEnd = Carbon::parse($this->end_date)->toDateString(); // If no end date, assume it's still active

        // Calculate the overlapping period
        $activeStart = Carbon::parse($contractStart)->isAfter($startOfMonth) ? $contractStart : $startOfMonth;
        $activeEnd = Carbon::parse($contractEnd)->isBefore($endOfMonth) ? $contractEnd : $endOfMonth;

        // Calculate the number of active days
        $activeDays = Carbon::parse($activeStart)->diffInDays($activeEnd) + 1;

        return $activeDays;
    }
    function EarnedSalaryKes($yearmonth)
    {
        $salary = 0;
        $offdays = 0;
        $daysWorked = $this->netDaysWorked($yearmonth);
        $daysOnLeave = $this->employee->daysOnLeave($yearmonth);
        $month = Carbon::parse($yearmonth);
        $monthdays = Carbon::parse($yearmonth)->daysInMonth;
        $daily_rate = $this->DailyRate($yearmonth);


        if ($this->employment_type->is_penalizable && $this->designation->is_penalizable) {
            $offdays = $this->EarnedOffDays($yearmonth);
            $salary = $daily_rate  * ($daysWorked + $daysOnLeave + $offdays);
        } else {
            if ($this->employment_type->rate_type == 'daily') {
                $salary = $daily_rate * $this->netDaysWorked($yearmonth);
            } else {
                $salary = $daily_rate * $this->daysActive($yearmonth);
            }
        }

        return $salary;
    }
    function EarnedOvertimeKes($yearmonth)
    {
        $extra_rate = 0;
        $now = Carbon::parse($yearmonth);
        $daily_rate = $this->DailyRate($yearmonth);

        foreach ($this->extra_works() as $key => $extra) {
            if (Carbon::parse($extra->date)->isBetween($now->firstOfMonth()->toDateString(), $now->lastOfMonth()->toDateString())) {
                if ($extra->double_shift) {
                    $extra_rate += 1;
                } else {
                    $extra_rate += 0.5;
                }
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
