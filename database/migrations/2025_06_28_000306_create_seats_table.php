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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hostel_id')->references('id')->on('hostels');
            $table->foreignId('building_id')->nullable()->references('id')->on('hostel_buildings');
            $table->string('floor',20)->nullable();
            $table->string('block',20)->nullable();
            $table->foreignId('room_id')->references('id')->on('rooms');
            $table->string('room_number',20);
            $table->string('room_type',20);
            $table->string('seat_number',20);
            $table->float('seat_maximum_price');
            $table->float('seat_minimum_price');
            $table->string('price_for',20);
            $table->boolean('has_any_service_charge')->default(0);
            $table->float('service_charge')->nullable();
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
        Schema::dropIfExists('seats');
    }
};
