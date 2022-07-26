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
        Schema::create('conference_halls', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('location_id')->constrained();
            $table->timestamps();
        });

        /* locationIds

        1:Main Area
        2: Residental
        3: Administration

        */


        DB::table('conference_halls')->insert([

            [
                'name'=>'Bankika',
                'location_id'=>1
            ],
            [
                'name'=>'Kilimanjaro',
                'location_id'=>2
            ],
            [
                'name'=>'Lewa',
                'location_id'=>2
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
        Schema::dropIfExists('conference_halls');
    }
};
