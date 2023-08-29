<?php

namespace App\Http\Livewire\Admin\Leaves;

use App\Models\Leave;
use Livewire\Component;

class Index extends Component
{
    function delete($id) {
        Leave::find($id)->delete();
        $this->emit('done', [
            'success'=>'This Leave has been Successfully Deleted'
        ]);
    }
    public function render()
    {
        return view('livewire.admin.leaves.index',[
            'leaves'=>Leave::all()
        ]);
    }
}
