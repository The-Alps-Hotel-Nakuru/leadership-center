<?php

namespace App\Http\Livewire\Admin\ExtraWorks;

use App\Models\EmployeesDetail;
use App\Models\ExtraWork;
use App\Models\Log;
use Carbon\CarbonPeriod;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Create extends Component
{
    public $employee_id, $date, $second_date, $double_shift;
    public $search = "";
    public $overtimesList = [];

    public $full = false;
    protected $listeners = [
        'done' => 'render'
    ];

    protected $rules = [
        'employee_id' => 'required',
        'date' => 'required',
        'second_date' => 'nullable',
        'double_shift' => 'required',
    ];


    public function selectEmployee($id)
    {
        $this->employee_id = $id;
    }


    public function addToList()
    {
        $this->validate();


        if ($this->overtimesList) {
            for ($i = 0; $i < count($this->overtimesList); $i++) {
                if (intval($this->overtimesList[$i][0]) == intval($this->employee_id) && $this->overtimesList[$i][1] == $this->date) {
                    throw ValidationException::withMessages([
                        'employee_id' => "This Employee's attendance on this day is already in the List"
                    ]);
                }
            }
        }



        if (EmployeesDetail::find($this->employee_id)->hasOvertimeOn($this->date)) {
            throw ValidationException::withMessages([
                'employee_id' => "This Employee already Clocked Overtime on this day"
            ]);
        }





        array_push($this->overtimesList, [$this->employee_id, $this->date, $this->double_shift]);

        $this->reset(['search', 'employee_id']);
    }

    public function addFullMonth()
    {

        $this->validate();

        if (!$this->date) {
            throw ValidationException::withMessages([
                'date' => "The Start Date is Required"
            ]);
        }
        if (!$this->second_date) {
            throw ValidationException::withMessages([
                'second_date' => "The End Date is Required"
            ]);
        }


        $period = CarbonPeriod::between($this->date, $this->second_date);

        foreach ($period as $date) {
            if ($this->overtimesList) {
                for ($i = 0; $i < count($this->overtimesList); $i++) {
                    if (intval($this->overtimesList[$i][0]) == intval($this->employee_id) && $this->overtimesList[$i][1] == $date->format('Y-m-d')) {
                        continue;
                    }
                }
            }



            if (EmployeesDetail::find($this->employee_id)->hasOvertimeOn($date->format('Y-m-d'))) {
                continue;
            }
            array_push($this->overtimesList, [$this->employee_id, $date->format('Y-m-d'), $this->double_shift]);
        }

        $this->reset(['search', 'employee_id']);
    }

    public function save()
    {
        if (count($this->overtimesList) > 0) {
            for ($i = 0; $i < count($this->overtimesList); $i++) {

                if (EmployeesDetail::find($this->overtimesList[$i][0])->hasOvertimeOn($this->overtimesList[$i][1])) {
                    throw ValidationException::withMessages([
                        'list' . $i => "This Employee already Clocked Overtime on this day"
                    ]);
                }
                $extrawork = new ExtraWork();
                $extrawork->employees_detail_id = intval($this->overtimesList[$i][0]);
                $extrawork->date = $this->overtimesList[$i][1];
                $extrawork->double_shift = $this->overtimesList[$i][2];

                $extrawork->save();
            }
            $log = new Log();
            $log->user_id = auth()->user()->id;
            $log->model = 'App\Models\ExtraWork';
            $log->payload = "<strong>" . auth()->user()->name . "</strong> has updated " . count($this->overtimesList) . " overtime records <strong> in the system";
            $log->save();

            $this->emit('done', [
                'success' => 'Successfully Updated ' . count($this->overtimesList) . ' Extra Hour records',
            ]);
            $this->reset();
        } else {
            $this->emit('done', [
                'danger' => 'There is nothing to Update. Your List is Empty',
            ]);
            # code...
        }
    }

    function removeFromList($key)
    {
        array_splice($this->overtimesList, $key, 1);

        foreach ($this->overtimesList as $key => $extrawork) {
            if (EmployeesDetail::find($extrawork[0])->hasOvertimeOn($extrawork[1])) {
                array_splice($this->overtimesList, $key, 1);
            }
        }
    }
    public function render()
    {
        $employees = EmployeesDetail::whereHas('user', function ($query) {
            $query->whereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $this->search . '%']);
        })->get();
        return view(
            'livewire.admin.extra-works.create',
            [
                'employees'=>$employees
            ]
        );
    }
}
