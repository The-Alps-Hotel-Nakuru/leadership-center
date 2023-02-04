<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConferenceHall extends Model
{
    use HasFactory;

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function eventOrders()
    {
        return $this->belongsToMany(EventOrder::class, 'conference_hall_event_order');
    }

    public function isBookedOn($date)
    {
        foreach ($this->eventOrders as $eventOrder) {
            if (Carbon::parse($date)->isBetween($eventOrder->start_date, $eventOrder->end_date)) {
                return true;
            }
        }
    }

    public function isBookedDuring($date1, $date2)
    {
        if (Carbon::parse($date1)->isBefore($date2)) {
            foreach ($this->eventOrders as $eventOrder) {
                if (Carbon::parse($date1)->lessThan($eventOrder->start_date)) {
                    if (Carbon::parse($date2)->lessThan($eventOrder->start_date)) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    if (Carbon::parse($date1)->greaterThan($eventOrder->end_date)) {
                        return false;
                    } else {
                        return true;
                    }
                }
            }
        } else {
            foreach ($this->eventOrders as $eventOrder) {
                if (Carbon::parse($date2)->lessThan($eventOrder->start_date)) {
                    if (Carbon::parse($date1)->lessThan($eventOrder->start_date)) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    if (Carbon::parse($date2)->greaterThan($eventOrder->end_date)) {
                        return false;
                    } else {
                        return true;
                    }
                }
            }
        }
    }


}
