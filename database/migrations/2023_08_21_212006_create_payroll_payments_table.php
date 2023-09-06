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
            $table->unique(['payroll_id', 'employees_detail_id']);
            $table->float('gross_salary');
            $table->float('nssf');
            $table->float('nhif');
            $table->float('paye');
            $table->float('housing_levy');
            $table->float('tax_rebate');
            $table->float('total_fines');
            $table->float('total_advances');
            $table->float('total_bonuses');
            $table->float('total_welfare_contributions');
            $table->foreignId('bank_id')->constrained();
            $table->string('account_number');
            $table->string('bank_slip_path')->nullable();
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
