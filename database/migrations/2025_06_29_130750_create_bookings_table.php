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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hostel_id')->references('id')->on('hostels');
            $table->foreignId('building_id')->references('id')->on('hostel_buildings');
            $table->string('floor',20);
            $table->foreignId('room_id')->references('id')->on('rooms');
            $table->foreignId('seat_id')->references('id')->on('seats');
            $table->foreignId('booking_person')->references('id')->on('booking_persons');
            $table->date('booking_start_date');
            $table->date('booking_end_date');
            $table->float('seat_price')->nullable();
            $table->float('seat_service_charge')->default(0)->nullable();
            $table->float('discount')->default(0)->nullable();
            $table->float('discount_price')->default(0)->nullable();
            $table->float('total_payable')->nullable();
            $table->float('total_paid')->nullable();
            $table->float('total_due')->nullable();
            $table->integer('payment_status')->default(0)->comment('0=unpaid 1=paid 2=partially paid')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
