<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    protected $fillable = [
        'employees_detail_id',
        'year',
        'month',
        'amount_kes',
        'reason',
    ];


    public function employee()
    {
        return $this->belongsTo(EmployeesDetail::class, 'employees_detail_id');
    }
}
