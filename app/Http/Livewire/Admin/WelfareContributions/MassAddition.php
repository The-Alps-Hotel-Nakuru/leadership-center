<?php

namespace App\Http\Livewire\Admin\WelfareContributions;

use App\Imports\WelfareContributionImport;
use App\Models\EmployeesDetail;
use App\Models\WelfareContribution;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class MassAddition extends Component
{

    use WithFileUploads;
    public $welfarecontributionFile;
    public $yearmonth;
    public $validWelfareContributions = [], $invalidWelfareContributions = [], $alreadyExisting = [];

    protected $rules = [
        'welfarecontributionFile' => 'required|mimes:xlsx,xls,csv,txt',
        'yearmonth' => 'required'
    ];

    function checkData()
    {
        $this->validate();
        $this->reset(['validWelfareContributions', 'invalidWelfareContributions', 'alreadyExisting']);
        // Store the uploaded file
        $filePath = $this->welfarecontributionFile->store('excel_files');

        // Import and parse the Excel data
        $import = new WelfareContributionImport;
        Excel::import($import, $filePath);

        // Access the parsed data
        $data = $import->getData();

        // dd($data);

        $values = [];

        $fields = ["ID Number", "Name", "Amount", "Reason"];

        for ($i = 0; $i < count($fields); $i++) {
            if ($data[0][$i] != $fields[$i]) {
                throw ValidationException::withMessages([
                    'welfarecontributionFile' => ['The Fields set are incorrect']
                ]);
            }
        }

        foreach ($data as $item) {
            if ($item[0] != null) {
                array_push($values, [$item[0], $item[1], $item[2], $item[3], Carbon::createFromFormat('Y-m', $this->yearmonth)->format('Y'), Carbon::createFromFormat('Y-m', $this->yearmonth)->format('m')]);
                // National Id, Name, Amount, reason, year, month
            }
        }
        for ($i = 1; $i < count($values); $i++) {
            $employee = EmployeesDetail::where('national_id', $values[$i][0]);
            if ($employee->exists()) {
                if (!$values[$i][0] || !$values[$i][1] || !$values[$i][2] ||!$values[$i][3] || !$values[$i][4] || !$values[$i][5]  ) {
                    array_push($this->invalidWelfareContributions, [$values[$i], "Missing Values"]);
                } else {
                    if (WelfareContribution::where('reason', $values[3])->where('employees_detail_id', $employee->first()->id)->where('year', $values[4])->where('month', $values[5])->exists()) {
                        array_push($this->alreadyExisting, $values[$i]);
                    } else {
                        array_push($this->validWelfareContributions, $values[$i]);
                    }
                }
            }
        }
    }

    function uploadWelfareContributions()
    {
        $count = 0;
        $amount = 0;

        foreach ($this->validWelfareContributions as $contribution) {
            $employee = EmployeesDetail::where('national_id', $contribution[0])->first();

            $newContribution = new WelfareContribution();
            $newContribution->employees_detail_id = $employee->id;
            $newContribution->year = $contribution[4];
            $newContribution->month = $contribution[5];
            $newContribution->amount_kes = floatval($contribution[2]);
            $newContribution->reason = $contribution[3];
            $newContribution->created_by = auth()->user()->id;
            $newContribution->save();
            $count++;
            $amount += $newContribution->amount_kes;
        }

        $this->emit('done', [
            'success' => "Successfully Added Welfare Contribution for " . $newContribution->reason . " done by " . $count . " entries amounting to KES " . number_format($amount, 2) . "."
        ]);
        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.welfare-contributions.mass-addition');
    }
}
