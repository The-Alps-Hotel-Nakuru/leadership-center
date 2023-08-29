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
        Schema::create('payroll_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')->constrained();
            $table->foreignId('employees_detail_id')->constrained();
            $table->float('gross_salary')->constrained();
            $table->float('nssf');
            $table->float('nhif');
            $table->float('income_tax');
            $table->float('total_relief');
            $table->float('housing_levy');
            $table->float('bonus');
            $table->float('total_fines');
            $table->float('total_advance');
            $table->float('total_bonuses');
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
        Schema::dropIfExists('payroll_payments');
    }
};
