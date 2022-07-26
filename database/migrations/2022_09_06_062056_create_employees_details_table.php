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
        Schema::create('employees_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('designation_id')->constrained();
            $table->string('phone_number');
            $table->longText('physical_address');
            $table->enum('marital_status',['married', 'single', 'divorced', 'widowed'])->default('single');
            $table->enum('gender',['male', 'female']);
            $table->integer('children')->default(0);
            $table->string('kra_pin');
            $table->string('kra_pin_path')->nullable();
            $table->string('nssf')->nullable();
            $table->string('nssf_path')->nullable();
            $table->string('nhif')->nullable();
            $table->string('nhif_path')->nullable();
            $table->date('birth_date');
            $table->mediumText('handicap')->nullable();
            $table->string('religion')->nullable();
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
        Schema::dropIfExists('employees_details');
    }
};
