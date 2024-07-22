<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;


    function package() {
        return $this->hasOne(Package::class, 'id', 'package_id');
    }

    function company() {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
