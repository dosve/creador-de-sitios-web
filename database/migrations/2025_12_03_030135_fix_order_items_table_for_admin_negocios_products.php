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
        Schema::table('order_items', function (Blueprint $table) {
            // Hacer blog_post_id nullable ya que los productos pueden venir de AdminNegocios
            $table->foreignId('blog_post_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Revertir el cambio (hacer obligatorio de nuevo)
            $table->foreignId('blog_post_id')->nullable(false)->change();
        });
    }
};
