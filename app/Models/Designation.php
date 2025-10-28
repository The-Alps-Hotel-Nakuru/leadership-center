<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $casts = [
        'is_penalizable' => 'boolean',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function responsibilities()
    {
        return $this->hasMany(Responsibility::class);
    }

    public function employees()
    {
        return $this->hasMany(EmployeesDetail::class);
    }
}
