<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConferenceHallEventOrderPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conference_hall_event_order', function (Blueprint $table) {
            $table->unsignedBigInteger('conference_hall_id')->index();
            $table->foreign('conference_hall_id', 'ch_id')->references('id')->on('conference_halls')->onDelete('cascade');
            $table->unsignedBigInteger('event_order_id')->index();
            $table->foreign('event_order_id', 'eo_id')->references('id')->on('event_orders')->onDelete('cascade');
            $table->primary(['conference_hall_id', 'event_order_id'], 'ch_eo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conference_hall_event_order');
    }
}
