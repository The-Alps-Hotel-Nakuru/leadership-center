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
        Schema::table('payroll_payments', function (Blueprint $table) {
            $table->decimal('gross_salary')->nullable()->change();
            $table->decimal('nssf')->nullable()->change();
            $table->decimal('nhif')->nullable()->change();
            $table->decimal('paye')->nullable()->change();
            $table->decimal('housing_levy')->nullable()->change();
            $table->dropColumn('tax_rebate');
            $table->dropColumn('attendance_penalty');
            $table->decimal('total_fines')->nullable()->change();
            $table->decimal('total_advances')->nullable()->change();
            $table->decimal('total_bonuses')->nullable()->change();
            $table->decimal('total_welfare_contributions')->nullable()->change();
            $table->decimal('nita')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payroll_payments', function (Blueprint $table) {
            $table->decimal('gross_salary')->nullable(false)->change();
            $table->decimal('nssf')->nullable(false)->change();
            $table->decimal('nhif')->nullable(false)->change();
            $table->decimal('paye')->nullable(false)->change();
            $table->decimal('housing_levy')->nullable(false)->change();
            $table->decimal('tax_rebate');
            $table->float('attendance_penalty')->default(0);
            $table->decimal('total_fines')->nullable(false)->change();
            $table->decimal('total_advances')->nullable(false)->change();
            $table->decimal('total_bonuses')->nullable(false)->change();
            $table->decimal('total_welfare_contributions')->nullable(false)->change();
            $table->decimal('nita')->nullable(false)->change();
        });
    }
};
