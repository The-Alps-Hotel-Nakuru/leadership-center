<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function employee()
    {
        return $this->hasOne(EmployeesDetail::class, 'id', 'employees_detail_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function clock()
    {
        return $this->hasOne(AttendanceClock::class);
    }

    function getFullDateAttribute()
    {
        return Carbon::parse($this->check_in)->format('jS \of F, Y H:i A');
    }
}
