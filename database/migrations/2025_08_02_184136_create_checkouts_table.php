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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->references('id')->on('booking_invoices');
            $table->foreignId('booking_person')->references('id')->on('booking_persons');
            $table->string('booking_person_name',60)->nullable();
            $table->string('booking_phone_number',60)->nullable();
            $table->string('booking_person_email',60)->nullable();
            $table->float('total_service_charge')->nullable();
            $table->float('total_payable')->nullable();
            $table->float('total_paid')->nullable();
            $table->float('total_due')->nullable();
            $table->float('total_penalty')->nullable();
            $table->float('paying_amount')->nullable();
            $table->string('paying_method',20)->nullable();
            $table->text('customer_review')->nullable();
            $table->customDefaults();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
