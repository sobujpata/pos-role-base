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
        Schema::create('shop_details', function (Blueprint $table) {
            $table->id();
            $table->string('shop_name', 100);
            $table->string('shop_email', 100)->nullable();
            $table->string('shop_phone', 100)->nullable();
            $table->string('shop_address', 255)->nullable();
            $table->string('logo_text', 50);
            $table->string('logo', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_details');
    }
};
