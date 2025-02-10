<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leave_types', function (Blueprint $table) {
            $table->decimal('monthly_accrual_rate', 5, 2)->nullable()->after('max_days'); // Days earned per month
            $table->integer('min_months_worked')->nullable()->after('monthly_accrual_rate'); // Months before eligibility
            $table->integer('full_pay_days')->nullable()->after('min_months_worked'); // Fully paid leave days
            $table->integer('half_pay_days')->nullable()->after('full_pay_days'); // Half-pay leave days
            $table->integer('carry_forward_limit')->nullable()->after('can_accumulate'); // Max days carried forward
            $table->boolean('is_gender_specific')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable()->after('is_gender_specific');
            $table->dropColumn('min_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_types', function (Blueprint $table) {
            $table->dropColumn([
                'monthly_accrual_rate',
                'min_months_worked',
                'full_pay_days',
                'half_pay_days',
                'carry_forward_limit',
                'is_gender_specific',
                'gender'
            ]);
            $table->unsignedInteger('min_days')->nullable();
        });
    }
};
