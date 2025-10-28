<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentType extends Model
{
    use HasFactory;

    protected $casts = [
        'penalizable' => 'boolean',
    ];

    function contracts()
    {
        return $this->hasMany(EmployeeContract::class);
    }
}
