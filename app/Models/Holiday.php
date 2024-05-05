<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    function getIsCoveredAttribute()
    {
        foreach (Payroll::all() as $key => $payroll) {
            if (Carbon::parse($this->date)->isBetween(Carbon::parse($payroll->year . '-' . $payroll->month)->firstOfMonth(), Carbon::parse($payroll->year . '-' . $payroll->month)->lastOfMonth()) && count($payroll->payments) > 0) {
                return true;
            }

            return false;
        }
    }
}
