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
        Schema::table('booking_invoices', function (Blueprint $table) {
            $table->timestamp('cancel_date')->after('cancel_status')->useCurrent();
            $table->timestamp('checkout_date')->after('checkeout_status')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_invoices', function (Blueprint $table) {
             $table->timestamp('cancel_date')->after('cancel_status')->nullable();
            $table->timestamp('checkout_date')->after('checkeout_status')->nullable();
        });
    }
};
