<?php

namespace App\Http\Livewire\Admin\Attendances;

use App\Models\Attendance;
use App\Models\EmployeesDetail;
use App\Models\Log;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Create extends Component
{

    public $employee_id, $date, $second_date, $check_in, $check_out;
    public $search = "";
    public $attendanceList = [];

    public $full = false;
    protected $listeners = [
        'done' => 'render'
    ];

    protected $rules = [
        'employee_id' => 'required',
        'date' => 'required',
        'second_date' => 'nullable',
        'check_in' => 'required',
        'check_out' => 'nullable',
    ];


    public function selectEmployee($id)
    {
        $this->employee_id = $id;
    }


    public function addToList()
    {
        $this->validate();

        if ($this->employee_id == 'all') {
            foreach (EmployeesDetail::all() as $key => $employee) {
                if (count($employee->ActiveContractsBetween($this->date, $this->second_date)) > 0) {
                    if ($this->attendanceList) {
                        for ($i = 0; $i < count($this->attendanceList); $i++) {
                            if (intval($this->attendanceList[$i][0]) == intval($employee->id) && $this->attendanceList[$i][1] == $this->date) {
                                continue;
                            }
                        }
                    }



                    if ($employee->hasSignedOn($this->date)) {
                        continue;
                    }

                    array_push($this->attendanceList, [$employee->id, $this->date, $this->check_in, $this->check_out]);
                }
            }

        } else {
            if ($this->attendanceList) {
                for ($i = 0; $i < count($this->attendanceList); $i++) {
                    if (intval($this->attendanceList[$i][0]) == intval($this->employee_id) && $this->attendanceList[$i][1] == $this->date) {
                        throw ValidationException::withMessages([
                            'employee_id' => "This Employee's attendance on this day is already in the List"
                        ]);
                    }
                }
            }



            if (EmployeesDetail::find($this->employee_id)->hasSignedOn($this->date)) {
                throw ValidationException::withMessages([
                    'employee_id' => "This Employee already signed in on this day"
                ]);
            }

            array_push($this->attendanceList, [$this->employee_id, $this->date, $this->check_in, $this->check_out]);
        }



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

        if ($this->employee_id == 'all') {
            foreach (EmployeesDetail::all() as $key => $employee) {
                if (count($employee->ActiveContractsBetween($this->date, $this->second_date)) > 0) {
                    $period = CarbonPeriod::between($this->date, $this->second_date);

                    foreach ($period as $date) {
                        if ($this->attendanceList) {
                            for ($i = 0; $i < count($this->attendanceList); $i++) {
                                if (intval($this->attendanceList[$i][0]) == intval($employee->id) && $this->attendanceList[$i][1] == $date->format('Y-m-d')) {
                                    continue;
                                }
                            }
                        }



                        if ($employee->hasSignedOn($date->format('Y-m-d'))) {
                            continue;
                        }
                        array_push($this->attendanceList, [$employee->id, $date->format('Y-m-d'), $this->check_in, $this->check_out]);
                    }
                }
            }
        } else {


            $period = CarbonPeriod::between($this->date, $this->second_date);

            foreach ($period as $date) {
                if ($this->attendanceList) {
                    for ($i = 0; $i < count($this->attendanceList); $i++) {
                        if (intval($this->attendanceList[$i][0]) == intval($this->employee_id) && $this->attendanceList[$i][1] == $date->format('Y-m-d')) {
                            continue;
                        }
                    }
                }

                if (EmployeesDetail::find($this->employee_id)->hasSignedOn($date->format('Y-m-d'))) {
                    continue;
                }
                array_push($this->attendanceList, [$this->employee_id, $date->format('Y-m-d'), $this->check_in, $this->check_out]);
            }
        }

        $this->reset(['search', 'employee_id']);
    }
    public function save()
    {
        if (count($this->attendanceList) > 0) {
            for ($i = 0; $i < count($this->attendanceList); $i++) {

                if (EmployeesDetail::find($this->attendanceList[$i][0])->hasSignedOn($this->attendanceList[$i][1])) {
                    throw ValidationException::withMessages([
                        'list' . $i => "This Employee already signed in on this day"
                    ]);
                }
                $attendance = new Attendance();
                $attendance->employees_detail_id = intval($this->attendanceList[$i][0]);
                $attendance->date = $this->attendanceList[$i][1];
                $attendance->check_in = Carbon::parse($this->attendanceList[$i][1] . ' ' . $this->attendanceList[$i][2])->toDateTimeString();
                $attendance->check_out = Carbon::parse($this->attendanceList[$i][1] . ' ' . $this->attendanceList[$i][3])->toDateTimeString();

                $attendance->save();
            }
            $log = new Log();
            $log->user_id = auth()->user()->id;
            $log->model = 'App\Models\Attendance';
            $log->payload = "<strong>" . auth()->user()->name . "</strong> has updated " . count($this->attendanceList) . " attendance records <strong> in the system";
            $log->save();

            $this->emit('done', [
                'success' => 'Successfully Updated ' . count($this->attendanceList) . ' attendance records',
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
        array_splice($this->attendanceList, $key, 1);

        foreach ($this->attendanceList as $key => $attendance) {
            if (EmployeesDetail::find($attendance[0])->hasSignedOn($attendance[1])) {
                array_splice($this->attendanceList, $key, 1);
            }
        }
    }
    public function render()
    {

        $employees = EmployeesDetail::whereHas('user', function ($query) {
            $query->where('first_name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%');
        })->get();

        return view('livewire.admin.attendances.create', [
            'employees' => $employees,
        ]);
    }
}
