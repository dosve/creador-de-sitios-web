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
        Schema::table('customers', function (Blueprint $table) {
            // Cambiar el tipo de admin_negocios_id a unsignedBigInteger
            $table->unsignedBigInteger('admin_negocios_id')->nullable()->change();
            
            // Agregar flag para saber si el customer está autenticado
            $table->boolean('is_authenticated')->default(false)->after('admin_negocios_id');
            
            // Agregar índice para búsquedas más rápidas
            $table->index('admin_negocios_id');
            $table->index(['website_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['admin_negocios_id']);
            $table->dropIndex(['website_id', 'email']);
            $table->dropColumn('is_authenticated');
        });
    }
};

