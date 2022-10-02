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
        return $this->hasOne(EmployeesDetail::class, 'id');
    }

    public function terminate(){
        $this->end_date = Carbon::now()->toDateString();
        $this->save();
    }
}
