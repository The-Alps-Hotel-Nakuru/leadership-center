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
        Schema::create('employment_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->timestamps();


        });

        DB::table('employment_types')->insert([
            [
                'title'=>'Casual',
                'description'=> 'Individuals on these contracts will accrue earnings based on the number of hours worked.'
            ],
            [
                'title'=>'Fixed-term',
                'description'=> 'apply to employees who work regular hours and are paid a salary. The contracts are ongoing until the set end date approaches, for example, after six months or one year'
            ],
            [
                'title'=>'Internship',
                'description'=> 'apply to employees who work regular hours and are paid a Stipend untaxed. The contracts are ongoing until the set end date approaches, for example, after six months or one year. The stipend is not to accrue deductions and any leverage on the intern is to be dispensed as a company expense.'
            ],
            [
                'title'=>'External',
                'description'=> 'apply to employees who work on External assistance Basis. Mostly consist of accountants, auditors and IT Staff their agreed salaries are untaxed and no benefits are to be paid'
            ],
            [
                'title'=>'Attachee',
                'description'=> 'apply to employees who work on School Attachment Basis. Mostly consist of all Production and Service Staff who are only allocated for Transport Allowance'
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
        Schema::dropIfExists('employment_types');
    }
};
