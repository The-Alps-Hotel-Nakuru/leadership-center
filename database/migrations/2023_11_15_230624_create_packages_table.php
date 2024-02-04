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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('max_employees');
            $table->integer('max_admins');
            $table->boolean('payroll')->default(false);
            $table->boolean('payslips')->default(false);
            $table->boolean('employee_portal')->default(false);
            $table->boolean('biometrics')->default(false);
            $table->boolean('mass_attendance')->default(false);
            $table->boolean('mass_bonus_fines')->default(false);
            $table->boolean('generate_bulk')->default(false);
            $table->float('monthly_cost');
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
        Schema::dropIfExists('packages');
    }
};
