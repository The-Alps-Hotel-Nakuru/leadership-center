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


    public function getIsActiveAttribute()
    {
        return Carbon::now()->lessThan($this->end_date);
    }


    public function employee()
    {
        return $this->hasOne(EmployeesDetail::class, 'id', 'employees_detail_id');
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
        if (Carbon::parse($date1)->greaterThan($date2)) {
            if (Carbon::parse($date1)->lessThan($this->start_date)) {
                if (Carbon::parse($date2)->lessThan($this->start_date)) {
                    return false;
                } else {
                    return true;
                }
            } else {
                if (Carbon::parse($date1)->greaterThan($this->end_date)) {
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            if (Carbon::parse($date2)->lessThan($this->start_date)) {
                if (Carbon::parse($date1)->lessThan($this->start_date)) {
                    return false;
                } else {
                    return true;
                }
            } else {
                if (Carbon::parse($date2)->greaterThan($this->end_date)) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }

    public function isActiveOn($date)
    {
        return Carbon::parse($date)->isBetween($this->start_date, $this->end_date);
    }
}
