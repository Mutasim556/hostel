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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hostel_id')->references('id')->on('hostels');
            $table->string('room_type',20);
            $table->string('floor',20);
            $table->string('block',20)->nullable();
            $table->string('room_number',40);
            $table->integer('room_dimension')->nullable();
            $table->boolean('is_full_bookable')->nullable();
            $table->float('full_room_max_price')->nullable();
            $table->float('full_room_min_price')->nullable();
            $table->boolean('has_attached_bath_room')->nullable();
            $table->boolean('has_attached_balcony')->nullable();
            $table->integer('total_window')->nullable();
            $table->integer('total_fan')->nullable();
            $table->integer('total_light')->nullable();
            $table->boolean('has_seats')->nullable();
            $table->integer('total_seats')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('delete')->default(0);
            $table->foreignId('created_by')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
