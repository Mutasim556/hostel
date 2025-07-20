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
        Schema::create('booking_persons', function (Blueprint $table) {
            $table->id();
            $table->string('booking_phone_number',20)->nullable()->uniqid;
            $table->string('booking_person_email',40)->nullable();
            $table->string('booking_person_name',40)->nullable();
            $table->string('booking_person_gender',20)->nullable();
            $table->date('booking_person_dob')->nullable();
            $table->string('booking_nid_number',30)->nullable();
            $table->string('booking_person_address',200)->nullable();
            $table->string('booking_service_id',50)->nullable();
            $table->string('booking_person_workplace_address',100)->nullable();
            $table->string('booking_person_image',100)->nullable();
            $table->string('booking_person_nid',100)->nullable();
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
        Schema::dropIfExists('booking_persons');
    }
};
