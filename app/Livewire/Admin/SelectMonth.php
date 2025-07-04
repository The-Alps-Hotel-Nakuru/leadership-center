<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SelectMonth extends Component
{
    public $yearmonth;

    protected $rules = [
        'yearmonth' => 'required|date_format:Y-m',
    ];

    public function mount()
    {
        // Initialize the yearmonth property with the current date
        $this->yearmonth = now()->format('Y-m');
    }

    public function changeYearmonth()
    {
        // Store the selected month in the session
        session()->put('yearmonth', $this->yearmonth);
        // Optionally, you can redirect to the dashboard or any other page
        return redirect()->route('admin.dashboard');
    }
    public function render()
    {
        return view('livewire.admin.select-month')->layout('layouts.guest');
    }
}
