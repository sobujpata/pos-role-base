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
        Schema::table('pos_invoice_tables', function (Blueprint $table) {
            Schema::dropIfExists('pos_invoice_products');
            Schema::dropIfExists('pos_invoices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_invoice_tables', function (Blueprint $table) {
            //
        });
    }
};
