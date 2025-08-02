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
        Schema::create('cancel_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->references('id')->on('booking_invoices');
            $table->float('total_payable')->nullable();
            $table->float('total_paid')->nullable();
            $table->float('total_service_charge')->nullable();
            $table->float('service_charge_refund')->default(0);
            $table->float('refund_amount')->nullable();
            $table->float('refund_otp')->nullable();
            $table->float('paying_amount')->nullable();
            $table->string('payment_method',50)->nullable();
            $table->string('type',3);
            $table->customDefaults();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancel_bookings');
    }
};
