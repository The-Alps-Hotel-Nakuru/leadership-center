<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    public function employee()
    {
        return $this->belongsTo(EmployeesDetail::class, 'employees_detail_id');
    }
    public function type()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function getDaysTakenAttribute()
    {
        return Carbon::parse($this->start_date)->diffInDays($this->end_date);
    }
}
