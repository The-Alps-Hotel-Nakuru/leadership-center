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
        Schema::create('clothing_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('size');
            $table->string('abbreviation');
            $table->timestamps();
        });

        DB::table(('clothing_sizes'))->insert([
            [
                'size'=>'Extra Small',
                'abbreviation'=>'XS'
            ],
            [
                'size'=>'Small',
                'abbreviation'=>'S'
            ],
            [
                'size'=>'Medium',
                'abbreviation'=>'M'
            ],
            [
                'size'=>'Large',
                'abbreviation'=>'L'
            ],
            [
                'size'=>'Extra Large',
                'abbreviation'=>'XL'
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
        Schema::dropIfExists('clothing_sizes');
    }
};
