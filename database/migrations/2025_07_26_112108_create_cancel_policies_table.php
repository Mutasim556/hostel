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
        Schema::create('cancel_policies', function (Blueprint $table) {
            $table->id();
            $table->boolean("has_policy_after_booking_started")->nullable();
            $table->integer('started_deduction')->nullable();
            $table->boolean('started_service_charge_deduction')->nullable();
            $table->integer('started_maximum_refund')->nullable();
            $table->boolean("has_policy_before_one_day")->nullable();
            $table->integer('one_day_deduction')->nullable();
            $table->boolean('one_day_service_charge_deduction')->nullable();
            $table->integer('one_day_maximum_refund')->nullable();
            $table->boolean("has_policy_before_two_day")->nullable();
            $table->integer('two_day_deduction')->nullable();
            $table->boolean('two_day_service_charge_deduction')->nullable();
            $table->integer('two_day_maximum_refund')->nullable();
            $table->boolean("has_policy_before_three_day")->nullable();
            $table->integer('three_day_deduction')->nullable();
            $table->boolean('three_day_service_charge_deduction')->nullable();
            $table->integer('three_day_maximum_refund')->nullable();
            $table->boolean("has_policy_before_five_day")->nullable();
            $table->integer('five_day_deduction')->nullable();
            $table->boolean('five_day_service_charge_deduction')->nullable();
            $table->integer('five_day_maximum_refund')->nullable();
            $table->boolean("has_policy_before_seven_day")->nullable();
            $table->integer('seven_day_deduction')->nullable();
            $table->boolean('seven_day_service_charge_deduction')->nullable();
            $table->integer('seven_day_maximum_refund')->nullable();
            $table->boolean("has_policy_before_eight_day")->nullable();
            $table->integer('eight_day_deduction')->nullable();
            $table->boolean('eight_day_service_charge_deduction')->nullable();
            $table->integer('eightday_maximum_refund')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancel_policies');
    }
};
