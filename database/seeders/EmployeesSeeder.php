<?php

namespace Database\Seeders;

use App\Models\Designation;
use App\Models\EmployeesDetail;
use App\Models\EmploymentType;
use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i=0; $i < 25; $i++) {
            $employee = new User();
            $details = new EmployeesDetail();

            $employee->first_name = $faker->firstName($i%3==0?'male':'female');
            $employee->last_name = $faker->lastName;
            $employee->role_id = 3;
            $employee->email = $employee->first_name.'-'.$employee->last_name.'@gmail.com';
            $employee->password = Hash::make(env('DEFAULT_PASSWORD'));
            $employee->save();

            $details->user_id = $employee->id;
            $details->designation_id =  rand(1, count(Designation::all()));
            $details->phone_number = $faker->phoneNumber;
            $details->gender = $i%3==0?'male':'female';
            $details->physical_address = $faker->address;
            $details->kra_pin = 'A'.random_int(100000000, 999999999).$faker->randomLetter;
            $details->birth_date = $faker->date('Y-m-d', '2000-02-28');
            $details->save();


            $log = new Log();
            $log->user_id = 1;
            $log->model = 'App\Models\EmployeesDetail';
            $log->payload = " Has Added a new Employee into the system by the name <strong>".$details->user->name."</strong> at <strong>".Carbon::parse($details->created_at)."</strong>";
            $log->save();
        }
    }
}
