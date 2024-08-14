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
        Schema::table('employment_types', function (Blueprint $table) {
            $table->enum('rate_type', ['daily', 'monthly'])->default('monthly');
            $table->boolean('is_penalizable')->default(true);
        });

        DB::table('employment_types')->insert([
            [
                'title' => 'Casual',
                'description' => 'Individuals on these contracts will accrue earnings based on the number of hours worked.',
                'rate_type'=>'daily',
                'is_penalizable'=>false,
            ],
            [
                'title' => 'Fixed-term',
                'description' => 'apply to employees who work regular hours and are paid a salary. The contracts are ongoing until the set end date approaches, for example, after six months or one year',
                'rate_type' => 'monthly',
                'is_penalizable' => true,
            ],
            [
                'title' => 'Internship',
                'description' =>
                'apply to employees who work regular hours and are paid a Stipend untaxed. The contracts are ongoing until the set end date approaches, for example, after six months or one year. The stipend is not to accrue deductions and any leverage on the intern is to be dispensed as a company expense.',
                'rate_type' => 'monthly',
                'is_penalizable' => true,
            ],
            [
                'title' => 'External',
                'description' =>
                'apply to employees who work on External assistance Basis. Mostly consist of accountants, auditors and IT Staff their agreed salaries are untaxed and no benefits are to be paid',
                'rate_type' => 'monthly',
                'is_penalizable' => false,
            ],
            [
                'title' => 'Trainee / School Attachee',
                'description' =>
                'apply to employees who work on School Attachment Basis. Mostly consist of all Production and Service Staff who are only allocated for Transport Allowance',
                'rate_type' => 'monthly',
                'is_penalizable' => true,
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
        Schema::table('employment_types', function (Blueprint $table) {
            $table->dropColumn('rate_type');
            $table->dropColumn('is_penalizable');
        });
    }
};
