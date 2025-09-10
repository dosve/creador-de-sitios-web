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
        Schema::table('users', function (Blueprint $table) {
            // Agregar la clave foránea a la tabla plans
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('set null');
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            // Agregar la clave foránea a la tabla categories
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar la clave foránea
            $table->dropForeign(['plan_id']);
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            // Eliminar la clave foránea
            $table->dropForeign(['category_id']);
        });
    }
};
