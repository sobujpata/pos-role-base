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
        Schema::table('pos_invoices', function (Blueprint $table) {
            $table->string('payMethod', 50)->after('user_id')->nullable();
            $table->string('custName', 255)->after('payMethod')->nullable();
            $table->text('notes')->after('custName')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_invoices', function (Blueprint $table) {
            $table->dropColumn('payMethod');
            $table->dropColumn('cusName');
            $table->dropColumn('notes');
        });
    }
};
