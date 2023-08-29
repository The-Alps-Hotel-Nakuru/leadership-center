<?php

namespace App\Http\Livewire\Admin\Banks;

use App\Models\Bank;
use Livewire\Component;

class Create extends Component
{
    public Bank $bank;

    protected $rules = [
        'bank.name' => 'required',
        'bank.short_name' => 'required',
        'bank.bank_code' => 'required',
        'bank.min_transfer' => 'nullable',
        'bank.max_transfer' => 'nullable',
    ];

    function mount()
    {
        $this->bank = new Bank();
    }


    function save()
    {
        $this->validate;
        $this->bank->save();

        $this->emit('done', [
            'success' => 'Successfully Saved a new Bank into the system'
        ]);
        $this->reset();
        $this->bank = new Bank();
    }
    public function render()
    {
        return view('livewire.admin.banks.create');
    }
}
