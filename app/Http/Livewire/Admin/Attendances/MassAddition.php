<?php

namespace App\Http\Livewire\Admin\Attendances;

use App\Imports\AttendancesImport;
use App\Models\Attendance;
use App\Models\EmployeesDetail;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class MassAddition extends Component
{
    use WithFileUploads;

    public $attendanceFile;
    public $validAttendances = [], $invalidAttendances = [], $alreadyExisting = [];

    protected $rules = [
        'attendanceFile' => 'required|mimes:xlsx,csv,txt'
    ];

    function checkData()
    {
        $this->validate();
        $this->reset(['validAttendances', 'invalidAttendances', 'alreadyExisting']);
        // Store the uploaded file
        $filePath = $this->attendanceFile->store('excel_files');

        // Import and parse the Excel data
        $import = new AttendancesImport();
        Excel::import($import, $filePath);

        // Access the parsed data
        $data = $import->getData();

        // dd($data);

        $values = [];

        $fields = ["Emp No.", "AC-No.", "No.", "Name", "Auto-Assign", "Date", "Timetable", "On duty", "Off duty", "Clock In", "Clock Out", "Normal", "Real time", "Late", "Early", "Absent", "OT Time", "Work Time", "Exception", "Must C/In", "Must C/Out", "Department", "NDays", "WeekEnd", "Holiday", "ATT_Time", "NDays_OT", "WeekEnd_OT", "Holiday_OT"];

        for ($i = 0; $i < count($fields); $i++) {
            if ($data[0][$i] != $fields[$i]) {
                throw ValidationException::withMessages([
                    'contractsFile' => ['The Fields set are incorrect']
                ]);
            }
        }

        foreach ($data as $item) {
            if ($item[0] != null) {
                array_push($values, [$item[2], $item[5], $item[9], $item[10] ?? null, $item[15]]);
                // National Id, Date, Clock in, Clock Out, Absent
            }
        }

        for ($i = 1; $i < count($values); $i++) {
            $employee = EmployeesDetail::where('national_id', $values[$i][0]);
            if (!$values[$i][0] || !$values[$i][1] || !$values[$i][2]) {
                array_push($this->invalidAttendances, $values[$i]);
            } elseif ($employee->exists()) {
                if ($employee->first()->ActiveContractOn($values[$i][1])) {
                    if (!$employee->first()->hasSignedOn($values[$i][1])) {
                        array_push($this->validAttendances, $values[$i]);
                    } else {
                        array_push($this->alreadyExisting, $values[$i]);
                    }
                }
            } else {
                array_push($this->invalidAttendances, $values[$i]);
            }
        }
    }

    function uploadAttendances()
    {
        $count = 0;
        foreach ($this->validAttendances as $attendance) {
            $newAttendance = new Attendance();
            $employee = EmployeesDetail::where('national_id', $attendance[0])->first();
            $newAttendance->employees_detail_id = $employee->id;
            $newAttendance->date = Carbon::parse($attendance[1])->toDateString();
            $newAttendance->check_in = Carbon::parse($attendance[1] . ' ' . $attendance[2])->toDateTimeString();
            $newAttendance->check_out = $attendance[3] ?
                Carbon::parse($attendance[1] . ' ' . $attendance[3])->toDateTimeString() :
                Carbon::parse($attendance[1] . ' ' . $attendance[2])->addHours(6)->toDateTimeString();
            $newAttendance->created_by = 1;
            $newAttendance->save();
            $count++;
        }

        $this->emit('done',[
            'success'=>"Successfully Uploaded {$count} attendance records"
        ]);
    }


    public function render()
    {
        return view('livewire.admin.attendances.mass-addition');
    }
}
