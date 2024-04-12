<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Designation;
use App\Models\EmployeeAccount;
use App\Models\EmployeesDetail;
use App\Models\EmploymentType;
use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('departments')->insert([
            [
                'title' => 'Housekeeping'
            ],
            [
                'title' => 'Accounts'
            ],
            [
                'title' => 'Information Technology'
            ],
            [
                'title' => 'Supply Chain & Procurement'
            ],
            [
                'title' => 'Front Office'
            ],
            [
                'title' => 'Food, Beverage and Service'
            ],
            [
                'title' => 'Kitchen'
            ],
            [
                'title' => 'Security'
            ],
            [
                'title' => 'Management'
            ],
        ]);

        DB::table('designations')->insert([


            //     'title'=>'Housekeeping'


            [
                'department_id' => 1,
                'title' => 'Laundry Attendant'
            ],
            [
                'department_id' => 1,
                'title' => 'Room Attendant'
            ],
            [
                'department_id' => 1,
                'title' => 'Public Area Attendant'
            ],
            [
                'department_id' => 1,
                'title' => 'Housekeeping Supervisor'
            ],


            //     'title'=>'Accounts'


            [
                'department_id' => 2,
                'title' => 'Senior Accountant'
            ],
            [
                'department_id' => 2,
                'title' => 'Junior Accountant'
            ],


            //     'title'=>'Information Technology'


            [
                'department_id' => 3,
                'title' => 'Chief Technology Officer'
            ],
            [
                'department_id' => 3,
                'title' => 'Networking and Communications Attendant'
            ],
            [
                'department_id' => 3,
                'title' => 'Hardware Engineer'
            ],
            [
                'department_id' => 3,
                'title' => 'Systems Analyst'
            ],


            //     'title'=>'Supply Chain & Procurement'


            [
                'department_id' => 4,
                'title' => 'Procurement Officer'
            ],
            [
                'department_id' => 4,
                'title' => 'Dry Goods Storekeeper'
            ],
            [
                'department_id' => 4,
                'title' => 'Equipments Storekeeper'
            ],
            [
                'department_id' => 4,
                'title' => 'Storage Clerk'
            ],


            //     'title'=>'Front Office'


            [
                'department_id' => 5,
                'title' => 'Receptionist'
            ],
            [
                'department_id' => 5,
                'title' => 'Front Office Supervisor'
            ],
            [
                'department_id' => 5,
                'title' => 'Driver'
            ],
            [
                'department_id' => 5,
                'title' => 'Concierge'
            ],


            //     'title'=>'Service'

            [
                'department_id' => 6,
                'title' => 'Cart Waiter/Waitress'
            ],
            [
                'department_id' => 6,
                'title' => 'Host/Hostess'
            ],
            [
                'department_id' => 6,
                'title' => 'Banquet Waiter/Waitress'
            ],
            [
                'department_id' => 6,
                'title' => 'Barista'
            ],
            [
                'department_id' => 6,
                'title' => 'Food, Beverage and Service Supervisor'
            ],


            //     'title'=>'Kitchen'


            [
                'department_id' => 7,
                'title' => 'Head Chef'
            ],
            [
                'department_id' => 7,
                'title' => 'Sous Chef'
            ],
            [
                'department_id' => 7,
                'title' => 'Station Chef'
            ],
            [
                'department_id' => 7,
                'title' => 'Sauce Chef'
            ],
            [
                'department_id' => 7,
                'title' => 'Pastry Chef'
            ],
            [
                'department_id' => 7,
                'title' => 'Butcher Chef'
            ],
            [
                'department_id' => 7,
                'title' => 'Fish Chef'
            ],
            [
                'department_id' => 7,
                'title' => 'Vegetable Chef'
            ],
            [
                'department_id' => 7,
                'title' => 'Pantry Chef (Garde Manger)'
            ],
            [
                'department_id' => 7,
                'title' => 'Grill Chef (Grillardin)'
            ],
            [
                'department_id' => 7,
                'title' => 'Chief Steward'
            ],
            [
                'department_id' => 7,
                'title' => 'Steward'
            ],


            //     'title'=>'Security'


            [
                'department_id' => 8,
                'title' => 'Day Security Guard'
            ],
            [
                'department_id' => 8,
                'title' => 'Head of Security'
            ],
            [
                'department_id' => 8,
                'title' => 'Night Security Guard'
            ],

            //     'title'=>'Management'

            [
                'department_id' => 9,
                'title' => 'General Manager'
            ],
            [
                'department_id' => 9,
                'title' => 'Operations Manager'
            ],
            [
                'department_id' => 9,
                'title' => 'Human Resource Manager'
            ],

        ]);
        $faker = Factory::create();

        for ($i = 0; $i < 25; $i++) {
            $employee = new User();
            $details = new EmployeesDetail();

            $employee->first_name = $faker->firstName($i % 3 == 0 ? 'male' : 'female');
            $employee->last_name = $faker->lastName;
            $employee->role_id = 3;
            $employee->email = $employee->first_name . '-' . $employee->last_name . '@gmail.com';
            $employee->password = Hash::make(env('DEFAULT_PASSWORD'));
            $employee->save();

            $details->user_id = $employee->id;
            $details->designation_id =  rand(1, count(Designation::all()));
            $details->national_id =  $faker->randomDigitNotZero();
            $details->phone_number = $faker->phoneNumber;
            $details->gender = $i % 3 == 0 ? 'male' : 'female';
            $details->physical_address = $faker->address;
            $details->kra_pin = 'A' . random_int(100000000, 999999999) . $faker->randomLetter;
            $details->birth_date = $faker->date('Y-m-d', '2000-02-28');
            $details->save();

            $account = new EmployeeAccount();
            $account->employees_detail_id = $details->id;
            $account->bank_id = rand(1, count(Bank::all()));
            $account->account_number = random_int(100000000, 99999999999999999);
            $account->save();

            $log = new Log();
            $log->user_id = 1;
            $log->model = 'App\Models\EmployeesDetail';
            $log->payload = " Has Added a new Employee into the system by the name <strong>" . $details->user->name . "</strong> at <strong>" . Carbon::parse($details->created_at) . "</strong>";
            $log->save();
        }
    }
}
