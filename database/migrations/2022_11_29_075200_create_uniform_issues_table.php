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
        Schema::create('uniform_issues', function (Blueprint $table) {
            $table->id();
            $table->string('uniform_code')->unique();
            $table->foreign('uniform_code')->references('code')->on('uniform_items')->cascadeOnDelete();
            $table->foreignId('employees_detail_id')->constrained();
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
        Schema::dropIfExists('uniform_issues');
    }
};
