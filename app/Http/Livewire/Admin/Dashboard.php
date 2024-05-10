<?php

namespace App\Http\Livewire\Admin;

use App\Exports\EmployeesDataExport;
use App\Models\Advance;
use App\Models\Bonus;
use App\Models\EmployeesDetail;
use App\Models\EventOrder;
use App\Models\Fine;
use App\Models\Log;
use App\Models\Payroll;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component

{
    use WithPagination;

    public $currentMonth, $currentMonthName, $currentYear, $today, $days, $instance, $employees;
    public $estimated = null;
    public $total_penalties = null;
    public $month;
    protected $paginationTheme = 'bootstrap';
    public $total_fines = null;
    public $total_bonuses = null;
    public $total_advances = null;
    public $incompleteEmployees;


    // private $columnChartModel;


    // for Payroll Graph
    public $monthsRange = [];
    public $labels = [];
    public $datasets = [];
    public $data = [];

    public $readyToLoad = false;


    public function loadItems()
    {
        $this->readyToLoad = true;
    }


    function downloadEmployeesData()
    {
        return Excel::download(new EmployeesDataExport, 'employees data.xlsx');

        $this->emit('done', [
            'success' => 'Employees data exported successfully'
        ]);
    }
    function loadPayrollGraph()
    {

        $range = [];
        $labels = [];
        $data = [];
        for ($i = 0; $i <= 7; $i++) {
            array_push($range, $this->instance->copy()->subMonthsNoOverflow(7 - $i));
        }
        foreach ($range as $month) {
            array_push($labels, $month->format('F, Y'));
            $payroll = Payroll::where('month', $month->format('m'))->where('year', $month->format('Y'));
            if ($payroll->exists()) {
                array_push($data, $payroll->first()->total);
            } else {
                array_push($data, 0);
            }
        }


        $this->monthsRange = $range;
        $this->labels = $labels;
        $this->data = $data;
    }

    function mount()
    {
        $this->instance = Carbon::now();
        $employees = EmployeesDetail::all();
        $this->today = $this->instance->format('Y-m-d');
        $this->month = $this->instance->format('Y-m');
        // $this->estimated = $this->estimated_earnings();
        // $this->loadPayrollGraph();
        // $this->incompleteEmployees = $this->incompleteEmployees();
    }

    function incompleteEmployees()
    {

        $employees = EmployeesDetail::where('kra_pin', null)->orWhere('nssf', null)->orWhere('nhif', null)->get();
        $collect = [];
        foreach ($employees as $employee) {
            if ($employee->isFullTimeBetween('01/01/1970', 'now')) {
                array_push($collect, $employee);
            }
        }
        return collect($collect);
    }

    function penalties()
    {
        $total_penalties = 0;
        foreach ($employees as $key => $employee) {
            $penalty = 0;
            $rate = 0;
            $days = $employee->daysWorked($this->instance->format('Y-m'));
            $leaveDays = $employee->daysOnLeave($this->instance->format('Y-m'));
            $daysMissed = $this->instance->daysInMonth - $days - $leaveDays;
            $contract = $employee->ActiveContractDuring($this->instance->format('Y-m'));

            if ($contract) {
                if ($employee->isCasualBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth()) || $employee->isInternBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth())) {
                    $rate = $contract->salary_kes;
                } else {
                    $rate = $contract->salary_kes / $this->instance->daysInMonth;
                }
            }
            if ($employee && $employee->isFullTimeBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth())) {
                if ($employee->isFullTimeBetween($this->instance->firstOfMonth(), $this->instance->lastOfMonth()) && $employee->designation->is_penalizable) {
                    if ($daysMissed > 6) {
                        $penalty = $rate * ($daysMissed - 6);
                    }
                } else {
                    $penalty = 0;
                }
            }
            $total_penalties += $penalty;
        }

        return $total_penalties;
    }

    function getNssf($sal)
    {
        $nssf = 0;

        if ($this->instance->isBefore('2024-01-31')) {
            $nssf = 200;
            if ($sal > (40000 / 12)) {
                $nssf = 0.06 * $sal;
                if ($nssf > 1080) {
                    $nssf = 1080;
                }
            }
        } else {
            if ($this->instance->isBefore('2024-03-31')) {
                $nssf = 420;
                if ($sal > (7000)) {
                    $nssf = 0.06 * $sal;
                    if ($nssf > 1740) {
                        $nssf = 1740;
                    }
                }
            } else {
                $nssf = 420;
                if ($sal > (7000)) {
                    $nssf = 0.06 * $sal;
                    if ($nssf > 2160) {
                        $nssf = 2160;
                    }
                }
            }
        }


        return $nssf;
    }

    function getNhif($sal)
    {
        $nhif = 0;

        if ($sal >= 0 && $sal < 6000) {
            $nhif = 150;
        } elseif ($sal >= 6000 && $sal < 8000) {
            $nhif = 300;
        } elseif ($sal >= 8000 && $sal < 12000) {
            $nhif = 400;
        } elseif ($sal >= 12000 && $sal < 15000) {
            $nhif = 500;
        } elseif ($sal >= 15000 && $sal < 20000) {
            $nhif = 600;
        } elseif ($sal >= 20000 && $sal < 25000) {
            $nhif = 750;
        } elseif ($sal >= 25000 && $sal < 30000) {
            $nhif = 850;
        } elseif ($sal >= 30000 && $sal < 35000) {
            $nhif = 900;
        } elseif ($sal >= 35000 && $sal < 40000) {
            $nhif = 950;
        } elseif ($sal >= 40000 && $sal < 45000) {
            $nhif = 1000;
        } elseif ($sal >= 45000 && $sal < 50000) {
            $nhif = 1100;
        } elseif ($sal >= 50000 && $sal < 60000) {
            $nhif = 1200;
        } elseif ($sal >= 60000 && $sal < 70000) {
            $nhif = 1300;
        } elseif ($sal >= 70000 && $sal < 80000) {
            $nhif = 1400;
        } elseif ($sal >= 80000 && $sal < 90000) {
            $nhif = 1500;
        } elseif ($sal >= 90000 && $sal < 100000) {
            $nhif = 1600;
        } elseif ($sal >= 100000) {
            $nhif = 1700;
        }


        return $nhif;
    }

    function getAhl($sal)
    {
        $levy = 0;
        if ($this->instance->isBefore('2024-01-31')) {
            $levy = 0.015 * $sal;
        } else {
            if ($this->instance->isBefore('2024-02-29')) {
                $levy = 0;
            } else {
                $levy = 0.015 * $sal;
            }
        }

        return $levy;
    }
    function estimated_earnings()
    {
        $earning = 0;
        $nssf = 0;
        $nhif = 0;
        $ahl = 0;
        foreach ($this->employees as $key => $employee) {
            $days = $employee->daysWorked($this->instance->format('Y-m'));
            $basic_salary_kes = 0;
            $contract = $employee->ActiveContractDuring($this->instance->format('Y-m'));
            if ($contract) {
                if ($contract->is_full_time()) {
                    $basic_salary_kes = $contract->salary_kes;
                    $nhif += $this->getNhif($basic_salary_kes);
                    $nssf += $this->getNssf($basic_salary_kes);
                    $ahl += $this->getAhl($basic_salary_kes);
                } else if ($contract->is_casual()) {
                    $basic_salary_kes = $contract->salary_kes * $days;
                } else if ($contract->is_intern()) {
                    $basic_salary_kes = $contract->salary_kes;
                } else if ($contract->is_external()) {
                    $basic_salary_kes = $contract->salary_kes;
                }
            } else {
                $basic_salary_kes = 0;
            }

            $gross = ($basic_salary_kes ?? 0);

            $earning += $gross;
        }

        return $earning + $nssf + $nhif + $ahl + $this->penalties() + $this->total_bonuses - $this->total_fines - $this->total_advances;
    }

    public function render()
    {
        $columnChartModel =
            (new ColumnChartModel())
            ->setTitle("Payroll Graph");
        if ($this->readyToLoad) {
            # code...
            $this->instance = Carbon::parse($this->month);

            $this->days = $this->instance->daysInMonth;
            $this->currentMonthName = $this->instance->format('F');
            $this->currentMonth = $this->instance->format('m');
            $this->currentYear = $this->instance->format('Y');

            $this->total_fines = 0;
            foreach (Fine::all() as $fine) {
                if ($fine->year == $this->instance->format('Y') && $fine->month == $this->instance->format('m')) {
                    $this->total_fines += $fine->amount_kes;
                }
            }
            $this->total_advances = 0;
            foreach (Advance::all() as $advance) {
                if ($advance->year == $this->instance->format('Y') && $advance->month == $this->instance->format('m')) {
                    $this->total_advances += $advance->amount_kes;
                }
            }
            $this->total_bonuses = 0;
            foreach (Bonus::all() as $bonus) {
                if ($bonus->year == $this->instance->format('Y') && $bonus->month == $this->instance->format('m')) {
                    $this->total_bonuses += $bonus->amount_kes;
                }
            }

            $this->estimated = $this->estimated_earnings();
            $this->total_penalties = $this->penalties();
            $this->loadPayrollGraph();
            $this->incompleteEmployees = $this->incompleteEmployees();

            foreach ($this->labels as $key => $label) {
                $columnChartModel->addColumn($label, $this->data[$key], "#242464");
            }
        }

        // $this->emit('loadedAll');


        return view('livewire.admin.dashboard', [
            'logs' => $this->readyToLoad ? Log::orderBy('id', 'DESC')->paginate(10) : [],
            'columnChartModel' => $this->readyToLoad ? $columnChartModel : new ColumnChartModel(),
        ]);
    }
}
