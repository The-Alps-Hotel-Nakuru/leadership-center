<?php

namespace App\Livewire\Admin\Attendances;

use App\Models\Attendance;
use App\Models\EmployeesDetail;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Edit extends Component
{
    public $month;
    public $year;
    public $employee;

    public $date;
    public $instance;
    public $check_in;
    public $check_out;
    public $search = "";
    public $attendanceList = [];
    protected $listeners = [
        'done' => 'render'
    ];

    protected $rules = [
        'date' => 'required',
        'check_in' => 'required',
        'check_out' => 'nullable',
    ];

    public function addToList()
    {
        $this->validate();


        if ($this->attendanceList) {
            for ($i = 0; $i < count($this->attendanceList); $i++) {
                if (intval($this->attendanceList[$i][0]) == intval($this->employee->id) && $this->attendanceList[$i][1] == $this->date) {
                    throw ValidationException::withMessages([
                        'date' => "This Employee's attendance on this day is already in the List"
                    ]);
                }
            }
        }



        if ($this->employee->hasSignedOn($this->date)) {
            throw ValidationException::withMessages([
                'date' => "This Employee already signed in on this day"
            ]);
        }





        array_push($this->attendanceList, [$this->employee->id, $this->date, $this->check_in, $this->check_out]);

        $this->reset(['date']);
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

            $this->dispatch(
                'done',
                success: 'Successfully Updated ' . count($this->attendanceList) . ' attendance records'
            );
            $this->reset(['attendanceList']);
        } else {
            $this->dispatch(
                'done',
                danger: 'There is nothing to update. Your List is empty'
            );
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

    function deleteAttendance($id)
    {
        // $attendance = Attendance::find($id);
        // $attendance->delete();
        Attendance::find($id)->deleteOrFail();

        $this->dispatch(
            'done',
            success: 'Successfully Deleted an attendance record',
        );
    }
    function mount($id, $instance)
    {
        $this->instance = $instance;
        $this->employee = EmployeesDetail::find($id);
        $this->attendanceList = $this->employee->attendancesOfMonth(Carbon::parse($this->instance)->format('Y-m'));
    }
    public function render()
    {
        return view('livewire.admin.attendances.edit');
    }
}
