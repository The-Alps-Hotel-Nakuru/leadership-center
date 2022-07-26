<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('hod')->nullable();
            $table->foreign('hod')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });

        DB::table('departments')->insert([
            [
                'title'=>'Housekeeping'
            ],
            [
                'title'=>'Accounts'
            ],
            [
                'title'=>'Information Technology'
            ],
            [
                'title'=>'Supply Chain & Procurement'
            ],
            [
                'title'=>'Front Office'
            ],
            [
                'title'=>'Food, Beverage and Service'
            ],
            [
                'title'=>'Kitchen'
            ],
            [
                'title'=>'Security'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
};
