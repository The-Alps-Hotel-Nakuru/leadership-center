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
        Schema::create('leave_request_leave', function (Blueprint $table) {
            $table->foreignId('leave_request_id')->unique()->constrained();
            $table->foreignId('leave_id')->unique()->constrained();
            $table->primary(['leave_id', 'leave_request_id']);
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
        Schema::dropIfExists('leave_request_leave');
    }
};
