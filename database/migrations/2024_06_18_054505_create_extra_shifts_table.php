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
        Schema::create('extra_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employees_detail_id')->constrained();
            $table->date('date');
            $table->unique(['employees_detail_id', 'date']);
            // $table->foreignId('shift_id')->constrained();
            $table->dateTime('check_in');
            $table->dateTime('check_out')->nullable();
            $table->enum('type', ['overtime', 'double-shift']);
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
        Schema::dropIfExists('extra_shifts');
    }
};
