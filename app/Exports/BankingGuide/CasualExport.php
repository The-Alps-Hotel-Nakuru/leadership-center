<?php

namespace App\Exports\BankingGuide;

use App\Models\EmployeesDetail;
use App\Models\Payroll;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CasualExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithColumnFormatting, ShouldAutoSize
{
    public $id;

    function __construct($id)
    {
        $this->id = $id;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $payroll = Payroll::find($this->id);

        $employees = [];

        foreach ($payroll->payments as $payment) {
            $employee = EmployeesDetail::find($payment->employees_detail_id);
            $first = Carbon::parse($payroll->year . '-' . $payroll->month)->firstOfMonth();
            $last = Carbon::parse($payroll->year . '-' . $payroll->month)->lastOfMonth();
            if ($employee->ActiveContractBetween($first, $last) && $payment->net_pay > 0) {
                array_push($employees, $payment);
            }
        }

        return collect($employees)->sortByDesc('net_pay');
    }

    public function headings(): array
    {
        return [
            "Debit/From Account",
            "Your Branch BIC/SORT Code",
            "Beneficiary Name",
            "Bank",
            "Branch",
            "BIC/SORT Code (Mpesa 99999)",
            "Account No./Phone Number",
            "Net Pay/Amount"
        ];
    }

    function title(): string
    {
        return "employees Employees";
    }


    public function map($row): array
    {
        return [
            env('BANK_ACCOUNT_NUMBER'),
            env('BANK_SORT'),
            $row->employee->user->name,
            $row->employee->bankAccount && $row->employee->bankAccount->bank ? $row->employee->bankAccount->bank->short_name : '',
            'NAIROBI',
            $row->employee->bankAccount && $row->employee->bankAccount->bank ? $row->employee->bankAccount->bank->bank_code : '',
            $row->employee->bankAccount && $row->employee->bankAccount->bank ? $row->employee->bankAccount->account_number : '',
            $row->net_pay
        ];
    }

    function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
}
