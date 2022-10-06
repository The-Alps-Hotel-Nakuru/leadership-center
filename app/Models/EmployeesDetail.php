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


    public function getHasActiveContractAttribute()
    {
        foreach ($this->contracts as $contract) {
            if ($contract->is_active) {
                return true;
            }
        }
        return false;
    }


    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function getAttendedDatesAttribute()
    {
        $dates=[];
        foreach($this->attendances as $item){
            array_push($dates, Carbon::parse($item->date)->format('Y-m-d'));
        }

        return $dates;
    }


    public function getCurrentMonthNumberAttribute()
    {
        $count = 0;

        foreach ($this->attendances as $attendance) {
            if (Carbon::parse($attendance->date)->format('Y-m')==Carbon::now()->format('Y-m')) {
                $count+=1;
            }
        }

        return $count;
    }
    public function getDaysWorkedAttribute($yearmonth)
    {
        $count = 0;

        foreach ($this->attendances as $attendance) {
            if (Carbon::parse($attendance->date)->format('Y-m')==Carbon::parse($yearmonth)->format('Y-m')) {
                $count+=1;
            }
        }

        return $count;
    }

    public function hasSignedInToday()
    {
        return in_array(Carbon::now()->format('Y-m-d'), $this->attended_dates);
    }


}
