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
        Schema::table('product_details', function (Blueprint $table) {
            $table->string('thumb_img1')->nullable();
            $table->string('thumb_img2')->nullable();
            $table->string('thumb_img3')->nullable();
            $table->string('thumb_img4')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropColumn(['thumb_img1', 'thumb_img2', 'thumb_img3', 'thumb_img4']);
        });
    }
};
