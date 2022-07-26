<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function subCategories()
    {
        return $this->hasMany(AssetSubcategory::class);
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
    public function updator()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}

