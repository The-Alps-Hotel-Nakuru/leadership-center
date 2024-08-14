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
            ['name' => 'MPESA', 'short_name' => 'MPESA', 'bank_code' => '99999'],
            ['name' => 'KCB Bank', 'short_name' => 'KCB', 'bank_code' => '01100'],
            ['name' => 'Standard Chartered Bank', 'short_name' => 'STANCHART', 'bank_code' => '02000'],
            ['name' => 'ABSA Bank', 'short_name' => 'ABSA', 'bank_code' => '03000'],
            ['name' => 'Bank of India', 'short_name' => 'BOI', 'bank_code' => '05000'],
            ['name' => 'Bank of Baroda', 'short_name' => 'BARODA', 'bank_code' => '06000'],
            ['name' => 'NCBA Bank', 'short_name' => 'NCBA', 'bank_code' => '07000'],
            ['name' => 'Stima Sacco', 'short_name' => 'STIMA', 'bank_code' => '08000'],
            ['name' => 'Interswitch Bank', 'short_name' => 'INTERSWITCH', 'bank_code' => '09000'],
            ['name' => 'Prime Bank', 'short_name' => 'PRIME', 'bank_code' => '10000'],
            ['name' => 'Co-operative Bank', 'short_name' => 'CO-OP', 'bank_code' => '11000'],
            ['name' => 'National Bank', 'short_name' => 'NBK', 'bank_code' => '12000'],
            ['name' => 'Oriental Bank', 'short_name' => 'ORIENTAL', 'bank_code' => '14000'],
            ['name' => 'Citi Bank', 'short_name' => 'CITI', 'bank_code' => '16000'],
            ['name' => 'Habib Bank AG Zurich', 'short_name' => 'HABIB', 'bank_code' => '17000'],
            ['name' => 'Middle East Bank', 'short_name' => 'MIDDLEEAST', 'bank_code' => '18000'],
            ['name' => 'Bank of Africa', 'short_name' => 'BOA', 'bank_code' => '19000'],
            ['name' => 'Consolidated Bank', 'short_name' => 'CONSOLIDATED', 'bank_code' => '23000'],
            ['name' => 'Credit Bank', 'short_name' => 'CREDIT', 'bank_code' => '25000'],
            ['name' => 'Access Bank', 'short_name' => 'ACCESS', 'bank_code' => '26004'],
            ['name' => 'Chase Bank', 'short_name' => 'CHASE', 'bank_code' => '30000'],
            ['name' => 'Stanbic Bank', 'short_name' => 'STANBIC', 'bank_code' => '31000'],
            ['name' => 'ABC Bank', 'short_name' => 'ABC', 'bank_code' => '35000'],
            ['name' => 'Ecobank', 'short_name' => 'ECOBANK', 'bank_code' => '43000'],
            ['name' => 'Spire Bank', 'short_name' => 'SPIRE', 'bank_code' => '49000'],
            ['name' => 'Paramount Bank', 'short_name' => 'PARAMOUNT', 'bank_code' => '50000'],
            ['name' => 'Jamii Bora Bank', 'short_name' => 'JAMIIBORA', 'bank_code' => '51000'],
            ['name' => 'Guaranty Trust Bank', 'short_name' => 'GT', 'bank_code' => '53000'],
            ['name' => 'Victoria Bank', 'short_name' => 'VICTORIA', 'bank_code' => '54000'],
            ['name' => 'Guardian Bank', 'short_name' => 'GUARDIAN', 'bank_code' => '55000'],
            ['name' => 'I&M Bank', 'short_name' => 'IANDM', 'bank_code' => '57000'],
            ['name' => 'Development Bank', 'short_name' => 'DEVELOPMENT', 'bank_code' => '59000'],
            ['name' => 'Fidelity Bank', 'short_name' => 'FIDELITY', 'bank_code' => '60000'],
            ['name' => 'Housing Finance', 'short_name' => 'HFC', 'bank_code' => '61000'],
            ['name' => 'Kenya Post Office Savings Bank', 'short_name' => 'POSTBANK', 'bank_code' => '62309'],
            ['name' => 'Diamond Trust Bank', 'short_name' => 'DTB', 'bank_code' => '63000'],
            ['name' => 'Mayfair Bank', 'short_name' => 'MAYFAIR', 'bank_code' => '65000'],
            ['name' => 'Sidian Bank', 'short_name' => 'SIDIAN', 'bank_code' => '66000'],
            ['name' => 'Equity Bank', 'short_name' => 'EQUITY', 'bank_code' => '68000'],
            ['name' => 'Family Bank', 'short_name' => 'FAMILY', 'bank_code' => '70000'],
            ['name' => 'Gulf African Bank', 'short_name' => 'GULF', 'bank_code' => '72000'],
            ['name' => 'First Community Bank', 'short_name' => 'FCB', 'bank_code' => '74000'],
            ['name' => 'DIB Bank', 'short_name' => 'DIB', 'bank_code' => '75000'],
            ['name' => 'UBA Bank', 'short_name' => 'UBA', 'bank_code' => '76000'],
            ['name' => 'Faulu Bank', 'short_name' => 'FAULU', 'bank_code' => '79000'],
            ['name' => 'KWFT Bank', 'short_name' => 'KWFT', 'bank_code' => '78000'],
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
