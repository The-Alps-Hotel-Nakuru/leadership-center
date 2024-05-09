<?php

namespace App\Http\Livewire\Admin\Payrolls;

use App\Models\Payroll;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class UploadPayment extends Component
{
    use WithFileUploads;

    public Payroll $payroll;
    public $payment_slip;

    protected $rules = [
        "payment_slip" => "required|mimes:pdf",
    ];

    protected $messages = [
        "payment_slip.required" => "You Must Upload a Payment Slip",
    ];
    public function mount($id)
    {
        $this->payroll = Payroll::findOrFail($id);
    }

    public function upload()
    {
        $this->validate();

        $fileName = Str::slug($this->payroll->yearmonth) . '.' . $this->payment_slip->extension();
        $this->payment_slip->storeAs('payment_slips/', $fileName, 'public');
        $this->payroll->payment_slip_path = 'payment_slips/'  . '/' . $fileName;
        $this->payroll->update();

        return redirect()->route('admin.payrolls.index');
    }
    public function render()
    {
        if (!count($this->payroll->payments) > 0) {
            abort(403, "You can't upload a payments slip path without generating the payments");
        }
        return view('livewire.admin.payrolls.upload-payment');
    }
}
