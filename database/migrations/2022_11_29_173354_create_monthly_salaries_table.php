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
        Schema::create('monthly_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employees_detail_id')->constrained();
            $table->year('year');
            $table->integer('month');
            $table->index(['year', 'month'], 'period');
            $table->unique(['employees_detail_id', 'year', 'month'], 'employee_period');
            $table->float('basic_salary_kes');
            $table->float('bonus_kes')->nullable();
            $table->float('house_allowance_kes')->nullable();
            $table->float('transport_allowance_kes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists('monthly_salaries');
    }
};
