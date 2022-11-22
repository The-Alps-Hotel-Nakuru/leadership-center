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
                'code' => 'B1',
                'min_kes_monthly' => 10000,
                'max_kes_monthly' => 14000,
            ],
            [
                'code' => 'B2',
                'min_kes_monthly' => 14000,
                'max_kes_monthly' => 17000,
            ],
            [
                'code' => 'B3',
                'min_kes_monthly' => 17000,
                'max_kes_monthly' => 21000,
            ],
            [
                'code' => 'B4',
                'min_kes_monthly' => 21000,
                'max_kes_monthly' => 24000,
            ],
            [
                'code' => 'B5',
                'min_kes_monthly' => 24000,
                'max_kes_monthly' => 28000,
            ],
            [
                'code' => 'C1',
                'min_kes_monthly' => 28000,
                'max_kes_monthly' => 37000,
            ],
            [
                'code' => 'C2',
                'min_kes_monthly' => 37000,
                'max_kes_monthly' => 46000,
            ],
            [
                'code' => 'C3',
                'min_kes_monthly' => 46000,
                'max_kes_monthly' => 55000,
            ],
            [
                'code' => 'C4',
                'min_kes_monthly' => 55000,
                'max_kes_monthly' => 64000,
            ],
            [
                'code' => 'C5',
                'min_kes_monthly' => 64000,
                'max_kes_monthly' => 82000,
            ],
            [
                'code' => 'D1',
                'min_kes_monthly' => 82000 ,
                'max_kes_monthly' => 112000,
            ],
            [
                'code' => 'D2',
                'min_kes_monthly' => 112000,
                'max_kes_monthly' => 132000,
            ],
            [
                'code' => 'D3',
                'min_kes_monthly' => 115000,
                'max_kes_monthly' => 155000,
            ],
            [
                'code' => 'D4',
                'min_kes_monthly' => 132000,
                'max_kes_monthly' => 172000,
            ],
            [
                'code' => 'D5',
                'min_kes_monthly' => 150000,
                'max_kes_monthly' => 200000,
            ],
            [
                'code' => 'E1',
                'min_kes_monthly' => 200000,
                'max_kes_monthly' => 260000,
            ],
            [
                'code' => 'E2',
                'min_kes_monthly' => 225000,
                'max_kes_monthly' => 285000,
            ],
            [
                'code' => 'E4',
                'min_kes_monthly' => 285000,
                'max_kes_monthly' => 585000,
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
