<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetItem extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
