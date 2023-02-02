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
        Schema::create('advances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employees_detail_id')->constrained();
            $table->dateTime('date_issued');
            $table->unsignedTinyInteger('start_after_months');
            $table->unsignedTinyInteger('pay_period_months');
            $table->string('transaction_id')->constrained();
            $table->float('amount_kes');
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
        Schema::dropIfExists('advances');
    }
};
