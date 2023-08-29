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
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('max_days')->nullable();
            $table->integer('min_days')->nullable();
            $table->boolean('is_paid')->default(true);
            $table->boolean('can_accumulate')->default(false);
            $table->timestamps();
        });

        DB::table('leave_types')->insert([
            [
                'title' => 'Annual Leave',
                'description' => 'Entitled after 12 months of work',
                'max_days' => 21,
                'is_paid' => true,
                'can_accumulate' => true,
            ],
            [
                'title' => 'Sick Leave',
                'description' => 'Up to 7 days per calendar year',
                'max_days' => 7,
                'is_paid' => true,
                'can_accumulate' => false,
            ],
            [
                'title' => 'Maternity Leave',
                'description' => '3 months with full pay',
                'max_days' => 90,
                'is_paid' => true,
                'can_accumulate' => false,
            ],
            [
                'title' => 'Paternity Leave',
                'description' => '2 weeks with full pay',
                'max_days' => 14,
                'is_paid' => true,
                'can_accumulate' => false,
            ],
            [
                'title' => 'Special Leave',
                'description' => 'Varies based on circumstances',
                'max_days' => null,
                'is_paid' => true,
                'can_accumulate' => false,
            ],
            [
                'title' => 'Unpaid Leave',
                'description' => 'Varies based on circumstances',
                'max_days' => null,
                'is_paid' => false,
                'can_accumulate' => true,
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
        Schema::dropIfExists('leave_types');
    }
};
