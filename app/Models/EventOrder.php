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

    public function conferenceHalls()
    {
        return $this->belongsToMany(ConferenceHall::class, 'conference_hall_event_order');
    }


    public function getDaysAttribute()
    {
        return Carbon::parse($this->start_date)->diffInDays($this->end_date) + 1;
    }


    public function getEarningsAttribute()
    {
        return $this->rate_kes * $this->pax * $this->days;
    }

    public function isDuringMonthOf($date)
    {
        $date = Carbon::parse($date);

        if (Carbon::parse($this->start_date)->greaterThanOrEqualTo($date->firstOfMonth()->toDateString())) {
            if (Carbon::parse($this->end_date)->greaterThanOrEqualTo($date->lastOfMonth()->toDateString())) {
                return false;
            }else{
                return true;
            }
        }else{
            if(Carbon::parse($this->end_date)->lessThan($date->firstOfMonth()->toDateString())){
                return false;
            }else{
                return true;
            }
        }


    }

}
