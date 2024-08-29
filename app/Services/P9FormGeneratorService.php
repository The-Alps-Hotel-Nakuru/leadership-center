<?php

namespace App\Services;

use App\Models\EmployeesDetail;
use App\Models\MonthlySalary;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class P9FormGeneratorService
{
    public function generate(EmployeesDetail $employee, $year = 2024)
    {

        $nameParts = explode(' ', trim($employee->user->name));

        $mainName = $nameParts[0]; // The first part is the main name
        $otherNames = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : 'N/A'; // The rest are the other names, or 'N/A' if none

        $monthlyData = [];
        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        // Initialize totals
        $totalEarnings = 0;
        $totalNssf = 0;
        $totalNhif = 0;
        $totalAhl = 0;
        $totalNita = 0;
        $totalIncomeTax = 0;
        $totalPersonalRelief = 0;
        $totalInsuranceRelief = 0;
        $totalPAYE = 0;
        // Example logic for generating P9 data
        foreach ($months as $index => $month) {
            $monthNumber = $index + 1; // Convert month to a number (1-12)

            // Query the MonthlySalary data for the given employee, year, and month
            $monthlySalaries = MonthlySalary::where('employees_detail_id', $employee->id)
                ->whereHas('payroll', function ($query) use ($year, $monthNumber) {
                    $query->where('year', $year)
                        ->where('month', $monthNumber);
                })
                ->get();

            $monthlyEarnings = $monthlySalaries->sum('gross_salary');
            $nssf = $monthlySalaries->sum('nssf');
            $nhif = $monthlySalaries->sum('nhif');
            $nita = $monthlySalaries->sum('nita');
            $incomeTax = $monthlySalaries->sum('income_tax');
            $personalRelief = $monthlySalaries->sum('tax_relief');
            $insuranceRelief = $monthlySalaries->sum('general_relief');
            $ahl = $monthlySalaries->sum('housing_levy');
            $monthlyPAYE = $monthlySalaries->sum('paye'); // Assuming 'paye' represents PAYE

            // Add to totals
            $totalEarnings += $monthlyEarnings;
            $totalNssf += $nssf;
            $totalNhif += $nhif;
            $totalAhl += $ahl;
            $totalNita += $nita;
            $totalPAYE += $monthlyPAYE;
            $totalIncomeTax += $incomeTax;
            $totalPersonalRelief += $personalRelief;
            $totalInsuranceRelief += $insuranceRelief;

            // Store the monthly data in the array
            $monthlyData[] = [
                'month' => $month,
                'earnings' => $monthlyEarnings,
                'nssf' => $nssf,
                'nhif' => $nhif,
                'nita' => $nita,
                'ahl' => $ahl,
                'incomeTax' => $incomeTax,
                'personalRelief' => $personalRelief,
                'insuranceRelief' => $insuranceRelief,
                'paye' => $monthlyPAYE,
            ];
        }

        // Prepare the final data array for the P9 form
        return [
            'employee_main_name' => $mainName,
            'employee_other_names' => $otherNames,
            'employee_pin' => $employee->kra_pin,
            'year' => $year,
            'monthly_data' => $monthlyData,
            'total_earnings' => $totalEarnings,
            'total_nssf' => $totalNssf,
            'total_nhif' => $totalNhif,
            'total_ahl' => $totalAhl,
            'total_nita' => $totalNita,
            'total_paye' => $totalPAYE,
            'total_income_tax' => $totalIncomeTax,
            'total_personal_relief' => $totalPersonalRelief,
            'total_insurance_relief' => $totalInsuranceRelief,
        ];
    }

    public function generatePdf($p9Data)
    {
        $pdf = Pdf::loadView('doc.p9', compact('p9Data'));
        return $pdf->download('p9_form.pdf');
    }
}
