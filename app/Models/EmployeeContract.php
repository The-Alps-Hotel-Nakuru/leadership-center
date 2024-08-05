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

    public function nhif()
    {
        $nhif = 0;

        if ($this->is_full_time()) {
            if ($this->salary_kes >= 0 && $this->salary_kes < 6000) {
                $nhif = 150;
            } elseif ($this->salary_kes >= 6000 && $this->salary_kes < 8000) {
                $nhif = 300;
            } elseif ($this->salary_kes >= 8000 && $this->salary_kes < 12000) {
                $nhif = 400;
            } elseif ($this->salary_kes >= 12000 && $this->salary_kes < 15000) {
                $nhif = 500;
            } elseif ($this->salary_kes >= 15000 && $this->salary_kes < 20000) {
                $nhif = 600;
            } elseif ($this->salary_kes >= 20000 && $this->salary_kes < 25000) {
                $nhif = 750;
            } elseif ($this->salary_kes >= 25000 && $this->salary_kes < 30000) {
                $nhif = 850;
            } elseif ($this->salary_kes >= 30000 && $this->salary_kes < 35000) {
                $nhif = 900;
            } elseif ($this->salary_kes >= 35000 && $this->salary_kes < 40000) {
                $nhif = 950;
            } elseif ($this->salary_kes >= 40000 && $this->salary_kes < 45000) {
                $nhif = 1000;
            } elseif ($this->salary_kes >= 45000 && $this->salary_kes < 50000) {
                $nhif = 1100;
            } elseif ($this->salary_kes >= 50000 && $this->salary_kes < 60000) {
                $nhif = 1200;
            } elseif ($this->salary_kes >= 60000 && $this->salary_kes < 70000) {
                $nhif = 1300;
            } elseif ($this->salary_kes >= 70000 && $this->salary_kes < 80000) {
                $nhif = 1400;
            } elseif ($this->salary_kes >= 80000 && $this->salary_kes < 90000) {
                $nhif = 1500;
            } elseif ($this->salary_kes >= 90000 && $this->salary_kes < 100000) {
                $nhif = 1600;
            } elseif ($this->salary_kes >= 100000) {
                $nhif = 1700;
            }
        }

        return $nhif;
    }

    public function paye($yearmonth)
    {
        $tax = 0;
        $level1 = (288000 / 12);
        $level2 = (388000 / 12);
        $level3 = (6000000 / 12);
        $level4 = (9600000 / 12);

        $taxable_income = $this->salary_kes - $this->nssf($yearmonth);

        if ($this->is_full_time()) {
            if ($taxable_income <= $level1) {
                $tax = $taxable_income * 0.1;
            } elseif ($taxable_income > $level1 && $taxable_income <= $level2) {
                $tax = (($taxable_income - $level1) * 0.25) + 2400;
            } elseif ($taxable_income > $level2 && $taxable_income <= $level3) {
                $tax = (($taxable_income - $level2) * 0.3) + (($level2 - $level1) * 0.25) + 2400;
            } elseif ($taxable_income > $level3 && $taxable_income <= $level4) {
                $tax = (($taxable_income - $level3) * 0.325) + (($level3 - $level2) * 0.3) + (($level2 - $level1) * 0.25) + 2400;
            } else {
                $tax = (($taxable_income - $level4) * 0.35) + (($level4 - $level3) * 0.325) + (($level3 - $level2) * 0.3) + (($level2 - $level1) * 0.25) + 2400;
            }
        }

        $relief = 0;
        if ($tax > 2400) {
            $relief = 2400;
        } else {
            $relief = $tax;
        }


        return $tax - $relief;
    }

    public function nssf($yearmonth)
    {
        $nssf = 0;

        if (Carbon::parse($yearmonth)->firstOfMonth()->isBefore('2024-01-31')) {
            if ($this->is_full_time()) {
                $nssf = 200;
                if ($this->gross_salary > (40000 / 12)) {
                    $nssf = 0.06 * $this->gross_salary;
                    if ($nssf > 1080) {
                        $nssf = 1080;
                    }
                }
            }
        } else {
            if ($this->is_full_time()) {
                $nssf = 420;
                if ($this->gross_salary > (7000)) {
                    $nssf = 0.06 * $this->gross_salary;
                    if ($nssf > 1740) {
                        $nssf = 1740;
                    }
                }
            }
        }


        return $nssf;
    }


    public function relief()
    {
        $relief = 0;

        if ($this->nhif()) {
            $relief += (0.15 * $this->nhif());
        }

        return $relief;
    }


}
