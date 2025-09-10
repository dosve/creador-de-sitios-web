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
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->boolean('is_product')->default(false)->after('is_published');
            $table->decimal('price', 10, 2)->nullable()->after('is_product');
            $table->integer('stock')->nullable()->after('price');
            $table->string('sku')->nullable()->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn(['is_product', 'price', 'stock', 'sku']);
        });
    }
};
