<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('event_orders', function (Blueprint $table) {
            $table->id();
            $table->string('organization_name');
            $table->string('event_name')->nullable();
            $table->string('contact_name');
            $table->foreignId('conference_hall_id')->constrained();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('pax');
            $table->text('table_setup')->nullable();
            $table->float('rate_kes');
            $table->boolean('breakfast')->default(false);
            $table->boolean('early_morning_tea')->default(false);
            $table->boolean('10AM_tea')->default(false);
            $table->boolean('lunch')->default(false);
            $table->boolean('4PM_tea')->default(false);
            $table->boolean('dinner')->default(false);
            $table->longText('meals')->nullable();
            $table->longText('beverages')->nullable();
            $table->longText('seminar_room')->nullable();
            $table->longText('equipment')->nullable();
            $table->longText('additions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_orders');
    }
};
