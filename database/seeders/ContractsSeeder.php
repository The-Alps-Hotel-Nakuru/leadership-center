<?php

namespace Database\Seeders;

use App\Models\Designation;
use App\Models\EmployeeContract;
use App\Models\EmployeesDetail;
use App\Models\EmploymentType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $contract = new EmployeeContract();
            $contract->employees_detail_id = rand(1, count(EmployeesDetail::all()));
            $contract->start_date = Carbon::now()->subMonths(rand(2, 16))->toDateString();
            $contract->end_date = Carbon::now()->addMonths(rand(0, 12))->toDateString();
            $contract->employment_type_id = rand(1, count(EmploymentType::all()));
            $contract->salary_kes = random_int(10, 50) * 1000;
            $contract->save();
        }
    }
}
