<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventOrder extends Model
{
    use HasFactory;


    protected $fillable = [
        'organization_name',
        'event_name',
        'contact_name',
        'conference_hall_id',
        'start_date',
        'end_date',
        'pax',
        'table_setup',
        'rate_kes',
        'breakfast',
        'early_morning_tea',
        '10AM_tea',
        'lunch',
        '4PM_tea',
        'dinner',
        'meals',
        'beverages',
        'beverages',
        'seminar_room',
        'equipment',
        'additions',
    ];

    public function getNewOrderAttribute()
    {
        if (Carbon::parse($this->created_at)->greaterThan(Carbon::now()->subMinutes(10)->toDate())) {
            return true;
        }
        return false;
    }

    public function conferenceHall()
    {
        return $this->belongsToMany(ConferenceHall::class, 'conference_hall_event_order');
    }
}
