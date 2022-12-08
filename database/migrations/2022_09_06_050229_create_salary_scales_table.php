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
        Schema::create('salary_scales', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->float('min_kes_monthly');
            $table->float('max_kes_monthly');
            $table->softDeletes();
            $table->timestamps();
        });


        DB::table('salary_scales')->insert([
            [
                'code' => 'A8',
                'min_kes_monthly' => 18000,
                'max_kes_monthly' => 20000,
            ],
            [
                'code' => 'A7',
                'min_kes_monthly' => 20000,
                'max_kes_monthly' => 25000,
            ],
            [
                'code' => 'A6',
                'min_kes_monthly' => 25000,
                'max_kes_monthly' => 35000,
            ],
            [
                'code' => 'A5',
                'min_kes_monthly' => 35000,
                'max_kes_monthly' => 65000,
            ],
            [
                'code' => 'A4',
                'min_kes_monthly' => 65000,
                'max_kes_monthly' => 80000,
            ],
            [
                'code' => 'A3',
                'min_kes_monthly' => 80000,
                'max_kes_monthly' => 100000,
            ],
            [
                'code' => 'A2',
                'min_kes_monthly' => 100000,
                'max_kes_monthly' => 500000,
            ],
            [
                'code' => 'A1',
                'min_kes_monthly' => 500000,
                'max_kes_monthly' => 2000000,
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
        Schema::dropIfExists('salary_scales');
    }
};
