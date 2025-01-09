<?php

namespace App\Livewire\Admin\Banks;

use App\Models\Bank;
use Livewire\Component;

class Edit extends Component
{
    public Bank $bank;

    protected function rules()
    {
        return [
            'bank.name' => 'required',
            'bank.short_name' => 'required',
            'bank.bank_code' => 'required',
            'bank.min_transfer' => 'nullable',
            'bank.max_transfer' => 'nullable',
        ];
    }

    function mount($id)
    {
        $this->bank = Bank::find($id);
    }


    function save()
    {
        $this->validate();
        $this->bank->update();

        return redirect()->route('admin.banks.index');
    }
    public function render()
    {
        return view('livewire.admin.banks.edit');
    }
}
