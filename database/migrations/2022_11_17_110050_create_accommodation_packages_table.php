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
        Schema::create('accommodation_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->float('rate_kes');
            $table->longText('charges');
            $table->timestamps();
        });

        DB::table('accommodation_packages')->insert([
            [
                'title'=>'Full Board Accommodation - Single Occupancy',
                'rate_kes'=>10560,
                'charges'=>'All main meals and 2 tea breaks, Seminar room, mineral water in seminar room-500ml twice a day, sweets, notebooks &pens, projector, flip chart papers and marker pens. Use of grounds'
            ],
            [
                'title'=>'Full Board Accommodation - Double Occupancy',
                'rate_kes'=>19120,
                'charges'=>'All main meals and 2 tea breaks
                Seminar room, mineral water in seminar room- 500ml twice a day, sweets, notebooks &pens, projector, flip chart papers and marker pens.
                Use of grounds'
            ],
            [
                'title'=>'Half Board Accommodation - Single Occupancy',
                'rate_kes'=>7020,
                'charges'=>'Buffet Dinner or Buffet Lunch; Continental Breakfast'
            ],
            [
                'title'=>'Half Board Accommodation - Double Occupancy',
                'rate_kes'=>12040,
                'charges'=>'Buffet Dinner or Buffet Lunch; Continental Breakfast'
            ],
            [
                'title'=>'Bed and Breakfast Accommodation - Per Person',
                'rate_kes'=>5670,
                'charges'=>'Continental Breakfast'
            ],
            [
                'title'=>'Bed Only - Per Person',
                'rate_kes'=>4620,
                'charges'=>'Accommodation Only'
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
        Schema::dropIfExists('accommodation_packages');
    }
};
