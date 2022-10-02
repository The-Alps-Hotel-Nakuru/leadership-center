<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained();
            $table->string('title');
            $table->timestamps();
        });

        DB::table('designations')->insert([
            // [
            //     'title'=>'Housekeeping'
            // ],

            [
                'department_id' => 1,
                'title' => 'Housekeeping Attendant'
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
            // [
            //     'title'=>'Accounts'
            // ],
            [
                'department_id' => 2,
                'title' => 'Senior Accountant'
            ],
            [
                'department_id' => 2,
                'title' => 'Junior Accountant'
            ],
            // [
            //     'title'=>'Information Technology'
            // ],
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
            // [
            //     'title'=>'Supply Chain & Procurement'
            // ],
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
            // [
            //     'title'=>'Front Office'
            // ],
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
            // [
            //     'title'=>'Service'
            // ],
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
            // [
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
            // ],
            // [
            //     'title'=>'Security'
            // ],
            [
                'department_id' => 7,
                'title' => 'Day Security Guard'
            ],
            [
                'department_id' => 7,
                'title' => 'Head of Security'
            ],
            [
                'department_id' => 7,
                'title' => 'Night Security Guard'
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('designations');
    }
};
