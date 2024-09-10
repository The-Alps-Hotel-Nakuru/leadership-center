<?php

namespace App\Http\Livewire\Admin\Employees;

use App\Models\EmployeesDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class MarkExit extends Component
{

    public EmployeesDetail $employee;

    public $date, $previous;



    function rules()
    {
        return [
            'date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (Carbon::now()->isBefore($value)) {
                        $fail('The exit date cannot be after today');
                    }
                }
            ],
        ];
    }
    function mount($id)
    {
        $this->date = Carbon::now()->toDateString();
        $this->employee = EmployeesDetail::find($id);
        $this->previous = URL::previous();
    }



    public function save()
    {
        $this->validate();
        if ($this->employee->ActiveContractOn($this->date) || $this->employee->ActiveContractsAfter($this->date)) {
            throw ValidationException::withMessages([
                'date' => "There is still a contract active on or after this date for this employee"
            ]);
        }

        $this->employee->exit_date = $this->date;

        $this->employee->update();

        return redirect($this->previous);
    }
    public function render()
    {
        return view('livewire.admin.employees.mark-exit');
    }
}
