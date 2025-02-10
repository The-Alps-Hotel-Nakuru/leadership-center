<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    public function leave() {
        return $this->hasMany(Leave::class);
    }
    public function leaves() {
        return $this->hasMany(Leave::class);
    }
}
