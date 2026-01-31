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
        Schema::table('attribute_product', function (Blueprint $table) {
        $table->unique(['product_id', 'attribute_id'], 'attribute_product_unique');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attribute_product', function (Blueprint $table) {
        $table->dropUnique('attribute_product_unique');
    });
    }
};
