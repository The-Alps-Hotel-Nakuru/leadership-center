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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employees_detail_id')->constrained()->cascadeOnDelete();
            $table->longText('reason');
            $table->decimal('amount', 8, 2);
            $table->year('year');
            $table->unsignedBigInteger('month');
            $table->index(['year', 'month'], 'first_payment_period');
            $table->string('transaction');
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
        Schema::dropIfExists('loans');
    }
};
