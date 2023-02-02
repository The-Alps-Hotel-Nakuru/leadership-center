<?php

use Carbon\Carbon;
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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });

        DB::table('shifts')->insert([
            [
                'title'=>'Morning Shift',
                'start_time'=>Carbon::parse('07:00')->toTimeString(),
                'end_time'=>Carbon::parse('15:00')->toTimeString()
            ],
            [
                'title'=>'Evening Shift',
                'start_time'=>Carbon::parse('15:00')->toTimeString(),
                'end_time'=>Carbon::parse('23:00')->toTimeString()
            ],
            [
                'title'=>'Midnight Shift',
                'start_time'=>Carbon::parse('23:00')->toTimeString(),
                'end_time'=>Carbon::parse('07:00')->toTimeString()
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
        Schema::dropIfExists('shifts');
    }
};
