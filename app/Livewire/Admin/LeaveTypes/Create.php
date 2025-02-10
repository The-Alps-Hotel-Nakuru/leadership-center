<?php

namespace App\Livewire\Admin\LeaveTypes;

use App\Models\LeaveType;
use Illuminate\Validation\ValidationException;
use Livewire\Component;


class Create extends Component
{
    public $leaveType;

    public function rules()
    {
        return [
            "leaveType.title" => "required",
            "leaveType.description" => "nullable",
            "leaveType.max_days" => "nullable",
            "leaveType.is_paid" => "required|default:false",
            "leaveType.can_accumulate" => "nullable",
            "leaveType.monthly_accrual_rate" => "nullable",
            "leaveType.min_months_worked" => "nullable",
            "leaveType.full_pay_days" => "nullable",
            "leaveType.half_pay_days" => "nullable",
            "leaveType.is_gender_specific" => "nullable",
            "leaveType.gender" => 'nullable',
        ];
    }


    public function mount()
    {
        $this->leaveType = new LeaveType();
    }

    public function save()
    {
        $this->validate();
        if ($this->leaveType->is_gender_specific && empty($this->leaveType->gender)) {
            throw ValidationException::withMessages([
                'leaveType.gender' => 'Gender Is Required if Leave is Gender specific'
            ]);
        }
        if ($this->leaveType->can_accumulate && empty($this->leaveType->carry_forward_limit)) {
            throw ValidationException::withMessages([
                'leaveType.carry_forward_limit' => 'Gender Is Required if Leave is Gender specific'
            ]);
        }
        try {
            $this->leaveType->save();
            return redirect()->route('admin.leave-types.index');
        } catch (\Exception $e) {
            $this->dispatch('done', error: "Something went wrong: " . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.admin.leave-types.create');
    }
}
