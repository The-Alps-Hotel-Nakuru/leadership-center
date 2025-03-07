<?php

namespace App\Livewire\Admin\Payrolls;

use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class UploadPayment extends Component
{
    use WithFileUploads;

    public $payroll;
    public $payment_slip;

    protected $rules = [
        "payment_slip" => "required|mimes:pdf",
    ];

    protected $messages = [
        "payment_slip.required" => "You Must Upload a Payment Slip",
    ];
    public function mount($id)
    {
        $this->payroll = Payroll::find($id);
    }

    public function save()
    {
        $this->validate();

        $fileName = Str::slug($this->payroll->yearmonth) . '.' . $this->payment_slip->extension();
        $this->payment_slip->storeAs('payment_slips/', $fileName, 'public');
        $this->payroll->payment_slip_path = 'payment_slips/'  . '/' . $fileName;
        $this->payroll->update();

        // $this->dispatch('done', success: "Upload Successful");

        return redirect()->route('admin.payrolls.index');
    }

    public function removePaymentSlip()
    {
        if (file_exists($this->payroll->payment_slip_path)) {
            Storage::disk('public')->delete($this->payroll->payment_slip_path);
        }
        $this->payroll->payment_slip_path = null;
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
