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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('abbreviation');
            $table->timestamps();
        });


        DB::table('units')->insert([
            [
                'title' => 'Kilogram',
                'abbreviation' => 'kg(s)',
            ],
            [
                'title' => 'Gram',
                'abbreviation' => 'g(s)',
            ],
            [
                'title' => 'Litre',
                'abbreviation' => 'l(s)',
            ],
            [
                'title' => 'Millilitre',
                'abbreviation' => 'ml(s)',
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
        Schema::dropIfExists('units');
    }
};
