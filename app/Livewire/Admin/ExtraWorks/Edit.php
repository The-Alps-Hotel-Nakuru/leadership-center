<?php

namespace App\Livewire\Admin\ExtraWorks;

use App\Models\ExtraWork;
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
    public $double_shift;
    public $search = "";
    public $extraWorksList = [];
    protected $listeners = [
        'done' => 'render'
    ];

    protected $rules = [
        'date' => 'required',
        'double_shift'=>'required',
    ];

    public function addToList()
    {
        $this->validate();


        if ($this->extraWorksList) {
            for ($i = 0; $i < count($this->extraWorksList); $i++) {
                if (intval($this->extraWorksList[$i][0]) == intval($this->employee->id) && $this->extraWorksList[$i][1] == $this->date) {
                    throw ValidationException::withMessages([
                        'date' => "This Employee's extrawork on this day is already in the List"
                    ]);
                }
            }
        }



        if ($this->employee->hasSignedOn($this->date)) {
            throw ValidationException::withMessages([
                'date' => "This Employee already signed in on this day"
            ]);
        }





        array_push($this->extraWorksList, [$this->employee->id, $this->date, $this->double_shift]);

        $this->reset(['date']);
    }
    public function save()
    {
        if (count($this->extraWorksList) > 0) {
            for ($i = 0; $i < count($this->extraWorksList); $i++) {

                if (EmployeesDetail::find($this->extraWorksList[$i][0])->hasSignedOn($this->extraWorksList[$i][1])) {
                    throw ValidationException::withMessages([
                        'list' . $i => "This Employee already signed in on this day"
                    ]);
                }
                $extrawork = new ExtraWork();
                $extrawork->employees_detail_id = intval($this->extraWorksList[$i][0]);
                $extrawork->date = $this->extraWorksList[$i][1];
                $extrawork->double_shift = $this->extraWorksList[$i][2];

                $extrawork->save();
            }
            $log = new Log();
            $log->user_id = auth()->user()->id;
            $log->model = 'App\Models\ExtraWork';
            $log->payload = "<strong>" . auth()->user()->name . "</strong> has updated " . count($this->extraWorksList) . " extrawork records <strong> in the system";
            $log->save();

            $this->dispatch(
                'done',
                success: 'Successfully Updated ' . count($this->extraWorksList) . ' extrawork records'
            );
            $this->reset(['extraWorksList']);
        } else {
            $this->dispatch(
                'done',
                danger: 'There is nothing to update. Your List is empty'
            );
        }
    }

    function removeFromList($key)
    {
        array_splice($this->extraWorksList, $key, 1);

        foreach ($this->extraWorksList as $key => $extrawork) {
            if (EmployeesDetail::find($extrawork[0])->hasSignedOn($extrawork[1])) {
                array_splice($this->extraWorksList, $key, 1);
            }
        }
    }

    function deleteExtraWork($id)
    {
        // $extrawork = ExtraWork::find($id);
        // $extrawork->delete();
        ExtraWork::find($id)->deleteOrFail();

        $this->dispatch(
            'done',
            success: 'Successfully Deleted an extrawork record',
        );
    }
    function mount($id, $instance)
    {
        $this->instance = $instance;
        $this->employee = EmployeesDetail::find($id);
        $this->extraWorksList = $this->employee->extraworksOfMonth(Carbon::parse($this->instance)->format('Y-m'));
    }
    public function render()
    {
        return view('livewire.admin.extra-works.edit');
    }
}
