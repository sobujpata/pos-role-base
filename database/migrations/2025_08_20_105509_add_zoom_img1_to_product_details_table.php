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
            $table->string('zoom_img1',255)->nullable()->after('img1');
            $table->string('zoom_img2',255)->nullable()->after('img2');
            $table->string('zoom_img3',255)->nullable()->after('img3');
            $table->string('zoom_img4',255)->nullable()->after('img4');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropColumn('zoom_img1');
            $table->dropColumn('zoom_img2');
            $table->dropColumn('zoom_img3');
            $table->dropColumn('zoom_img4');
        });
    }
};
