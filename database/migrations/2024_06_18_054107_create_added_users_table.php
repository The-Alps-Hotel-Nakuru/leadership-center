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
        Schema::create('added_users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->foreignId('role_id')->constrained();
            $table->foreignId('designation_id')->constrained();
            $table->unsignedBigInteger('national_id');
            $table->string('phone_number')->unique();
            $table->longText('physical_address')->nullable();
            $table->enum('marital_status', ['married', 'single', 'divorced', 'widowed'])->default('single');
            $table->enum('gender', ['male', 'female']);
            $table->string('kra_pin')->nullable();
            $table->string('kra_pin_path')->nullable();
            $table->string('nssf')->nullable();
            $table->string('nssf_path')->nullable();
            $table->string('nhif')->nullable();
            $table->string('nhif_path')->nullable();
            $table->date('birth_date');
            $table->mediumText('handicap')->nullable();
            $table->string('religion')->nullable();
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
        Schema::dropIfExists('added_users');
    }
};
