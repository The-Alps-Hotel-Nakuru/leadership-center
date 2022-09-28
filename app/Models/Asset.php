<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $appends = [
        'image_url'
    ];

    public function getImageUrlAttribute()
    {
        return $this->image_path??'https://ui-avatars.com/api/?color=FFF&background=3354A2';
    }

    public function asset_category()
    {
        return $this->belongsTo(AssetCategory::class);
    }
    public function asset_subcategory()
    {
        return $this->belongsTo(AssetSubcategory::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
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
