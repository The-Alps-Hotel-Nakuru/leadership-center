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
        Schema::create('accommodation_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_order_id')->nullable()->constrained();
            $table->string('group_name')->nullable();
            $table->string('guest_name');
            $table->foreignId('room_id')->nullable();
            $table->date('check_in');
            $table->date('check_out')->nullable();
            $table->foreignId('accommodation_package_id')->constrained();
            $table->float('rate_kes');
            $table->float('discount_percentage')->default(0);
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
        Schema::dropIfExists('accommodation_bookings');
    }
};
