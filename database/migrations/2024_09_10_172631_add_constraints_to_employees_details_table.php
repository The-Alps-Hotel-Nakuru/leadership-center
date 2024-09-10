<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('employees_details', function (Blueprint $table) {
            $table->date('recruitment_date')->nullable();
            $table->date('exit_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees_details', function (Blueprint $table) {
            $table->dropColumn('recruitment_date');
            $table->dropColumn('exit_date');
        });
    }
};
