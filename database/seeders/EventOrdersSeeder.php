<?php

namespace Database\Seeders;

use App\Models\ConferenceHall;
use App\Models\ConferencePackage;
use App\Models\EventOrder;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        foreach (range(1, 1000) as $i) {
            $order = new EventOrder();
            $order->organization_name = $faker->company;
            $order->event_name = 'Training for new members of ' . $order->organization_name;
            $order->contact_name = $faker->name;
            $order->start_date = $faker->date('Y-m-d');
            $order->end_date = Carbon::parse($order->start_date)->addDays(rand(4, 14))->format('Y-m-d');
            $order->pax = rand(50, 250);
            $order->table_setup = 'round';
            $order->rate_kes = ConferencePackage::find(rand(1, count(ConferencePackage::all())))->rate_kes;
            $order->breakfast = true;
            $order->early_morning_tea = true;
            $order->midmorning_tea = true;
            $order->lunch = true;
            $order->afternoon_tea = false;
            $order->dinner = true;
            $order->meals = $faker->realText(100);
            $order->beverages = $faker->realText(100);
            $order->seminar_room = $faker->realText(100);
            $order->equipment = $faker->realText(100);
            $order->additions = $faker->realText(100);
            $order->save();
            $order->conferenceHall()->attach(rand(1, count(ConferenceHall::all())));
        }
    }
}
