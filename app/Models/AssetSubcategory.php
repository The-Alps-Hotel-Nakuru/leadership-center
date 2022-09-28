<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetSubcategory extends Model
{
    use HasFactory;

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
    public function updator()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
