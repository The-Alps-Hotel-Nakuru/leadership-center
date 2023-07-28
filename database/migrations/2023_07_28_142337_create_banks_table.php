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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->string('bank_code');
            $table->float('min_transfer')->default(10.00);
            $table->float('max_transfer')->nullable();
            $table->timestamps();
        });

        $banks = [
            ['name' => 'KCB Bank', 'short_name' => 'KCB', 'bank_code' => '01103'],
            ['name' => 'ABSA Bank', 'short_name' => 'ABSA', 'bank_code' => '03065'],
            ['name' => 'EQUITY Bank', 'short_name' => 'EQUITY', 'bank_code' => '68000'],
            ['name' => 'Stanbic Bank', 'short_name' => 'STANBIC', 'bank_code' => '31014'],
            ['name' => 'Co-operative Bank', 'short_name' => 'CO-OP', 'bank_code' => '11002'],
            ['name' => 'DTB Bank', 'short_name' => 'DTB', 'bank_code' => '63000'],
            ['name' => 'Consolidated Bank', 'short_name' => 'CONSOLIDATED', 'bank_code' => '23011'],
            ['name' => 'Postbank', 'short_name' => 'POSTBANK', 'bank_code' => '62001'],
            ['name' => 'MPESA', 'short_name' => 'MPESA', 'bank_code' => '99999'],
            ['name' => 'National Bank', 'short_name' => 'NBK', 'bank_code' => '12000'],
            ['name' => 'Standard Chartered Bank', 'short_name' => 'STANCHART', 'bank_code' => '02006'],
            ['name' => 'Family Bank', 'short_name' => 'FAMILY', 'bank_code' => '70000'],
            ['name' => 'I&M Bank', 'short_name' => 'I&M', 'bank_code' => '57000'],
            ['name' => 'Prime Bank', 'short_name' => 'PRIME', 'bank_code' => '10000'],
            ['name' => 'Guardian Bank', 'short_name' => 'GUARDIAN', 'bank_code' => '55001'],
        ];

        DB::table('banks')->insert($banks);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banks');
    }
};
