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
        Schema::create('hostels', function (Blueprint $table) {
            $table->id();
            $table->string('hostel_name',100);
            $table->string('hostel_type',50);
            $table->string('hostel_phone',16);
            $table->string('hostel_email',40)->nullable();
            $table->string('hostel_address',200)->nullable();
            $table->text('hostel_map_location')->nullable();
            $table->string('concern_person_name',100)->nullable();
            $table->string('concern_person_phone', 16)->nullable();
            $table->string('concern_person_email', 40)->nullable();
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
        Schema::dropIfExists('hostels');
    }
};
