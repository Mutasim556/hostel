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
            $table->foreignId('created_by')->after('delete')->references('id')->on('admins');
            $table->foreignId('updated_by')->after('created_by')->nullable()->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_invoices', function (Blueprint $table) {
            //
        });
    }
};
