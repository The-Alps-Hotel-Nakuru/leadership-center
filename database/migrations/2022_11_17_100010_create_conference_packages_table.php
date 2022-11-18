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
        Schema::create('conference_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->float('rate_kes');
            $table->longText('charges');
            $table->timestamps();
        });

        DB::table('conference_packages')->insert([
            [
                'title'=>'Full Day Conference - Per Person',
                'rate_kes'=>3990,
                'charges'=>'2 tea breaks with assorted snacks; Buffet Lunch; Seminar room, mineral water in seminar room- 500ml twice a day, sweets, notebooks &pens, projector, flip chart papers and marker pens.; Use of grounds, projector, flip chart papers and marker pens. Use of grounds'
            ],
            [
                'title'=>'Half Day Conference - Per Person',
                'rate_kes'=>3520,
                'charges'=>'Morning or Afternoon Tea Break with assorted snacks; Buffet Lunch; Seminar room, mineral water in seminar room, sweets, notebooks &pens, projector, flip chart papers and marker pens.; Use of grounds, projector, flip chart papers and marker pens. Use of grounds'
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
        Schema::dropIfExists('conference_packages');
    }
};
