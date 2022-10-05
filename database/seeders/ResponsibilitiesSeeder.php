<?php

namespace Database\Seeders;

use App\Models\Designation;
use App\Models\Responsibility;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResponsibilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker =  Factory::create();

        for ($i=0; $i < count(Designation::all()) ; $i++) {
            for ($j=0; $j < rand(10, 26); $j++) {
                $responsibility = new Responsibility();
                $responsibility->designation_id = $i+1;
                $responsibility->responsibility = $faker->realText();
                $responsibility->save();
            }
        }
    }
}
