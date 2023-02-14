<?php

namespace App\Http\Livewire\Employee;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Component;

class Dashboard extends Component
{
    public $total_fines = 0;
    public $total_bonuses = 0;
    public $attendance_percentage = 0;


    public function mount()
    {
        foreach (auth()->user()->employee->fines as $fine) {
            $this->total_fines += $fine->amount_kes;
        }
        foreach (auth()->user()->employee->bonuses as $bonus) {
            $this->total_bonuses += $bonus->amount_kes;
        }

        $now = Carbon::now();
        $firstday = $now->firstOfMonth()->toDateString();
        $today = $now->toDateString();
        $dates = [];

        // Create a period between the two dates
        $period = CarbonPeriod::create($firstday, 'now')->toArray();


        // Iterate over the period and add each date to the array
        foreach ($period as $date) {
            array_push($dates, $date->toDateString());
        }

        $count = 0;

        foreach (auth()->user()->employee->attended_dates as $date) {

            $dateString = Carbon::parse($date)->toDateString();

            if (in_array($date, $dates)) {
                $count++;
            }
        }



        $this->attendance_percentage = ($count / count($dates)) * 100;
    }
    public function render()
    {
        return view('livewire.employee.dashboard');
        // dd($this->attendance_percentage);
    }
}
