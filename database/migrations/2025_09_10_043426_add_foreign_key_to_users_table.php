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

        // La clave foránea category_id ya existe en la tabla blog_posts
        // No es necesario agregarla nuevamente
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

        // No hay clave foránea category_id para eliminar
    }
};
