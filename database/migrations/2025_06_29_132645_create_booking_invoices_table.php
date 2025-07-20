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
        Schema::create('booking_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_person')->references('id')->on('booking_persons');
            $table->date('booking_start_date');
            $table->date('booking_end_date');
            $table->float('seat_price');
            $table->float('seat_service_charge')->default(0);
            $table->float('discount')->default(0);
            $table->float('discount_price')->default(0);
            $table->float('total_payable');
            $table->float('total_paid');
            $table->float('total_due');
             $table->integer('payment_status')->default(0)->comment('0=unpaid 1=paid 2=partially paid');
            $table->boolean('status');
            $table->boolean('delete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_invoices');
    }
};
