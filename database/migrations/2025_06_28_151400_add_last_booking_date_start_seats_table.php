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
        Schema::table('seats', function (Blueprint $table) {
            $table->date('last_booking_start_date')->nullable()->after('service_charge');
            $table->date('last_booking_end_date')->nullable()->after('last_booking_start_date');
            $table->boolean('last_booking_status')->default(0)->after('last_booking_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seats', function (Blueprint $table) {
            //
        });
    }
};
