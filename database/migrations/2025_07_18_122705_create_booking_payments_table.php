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
        Schema::create('booking_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->references('id')->on('booking_invoices');
            $table->timestamp('payment_date');
            $table->float('payable_amount');
            $table->float('pay_amount');
            $table->float('due_amount');
            $table->string('payment_method',50);
            $table->text('note')->nullable();
            $table->boolean('invoice_status')->comment('0=Unpaid,1=Paid,2=Partially Paid');
            $table->customDefaults();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_payments');
    }
};
