<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    function leave_type()
    {
        return $this->belongsTo(LeaveType::class);
    }

    function employee()
    {
        return $this->belongsTo(EmployeesDetail::class, 'employees_detail_id');
    }

    function leaves()
    {
        return $this->belongsToMany(Leave::class, 'leave_request_leave', 'leave_request_id', 'leave_id');
    }

    function getDaysRequestedAttribute()
    {
        return Carbon::parse($this->start_date)->diffInDays($this->end_date) + 1 . " days";
    }

    function getIsPendingAttribute()
    {
        return $this->is_rejected ? false : (count($this->leaves) > 0 ? false : true);
    }
    function getIsApprovedAttribute()
    {
        return $this->is_rejected ? false : (count($this->leaves) > 0 ? true : false);
    }

    function getStatusAttribute()
    {
        return $this->is_rejected ? "<strong class='text-danger'>Rejected</strong>" : (count($this->leaves) > 0 ? "<strong class='text-success'>Approved</strong>" : "<strong class='text-warning'>Pending</strong>");
    }
}
