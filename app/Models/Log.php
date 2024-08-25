<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payload',
        'model',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
