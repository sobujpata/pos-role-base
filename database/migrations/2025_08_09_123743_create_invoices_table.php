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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('subtotal',50);
            $table->string('shipping',50);
            $table->string('total',50);
            $table->string('name', 100);
            $table->string('phone', 15);
            $table->string('address', 255);
            $table->string('status')->default('pending'); // Added status field
            $table->string('payment_method')->default('cash_on_delivery'); // Added payment method
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
