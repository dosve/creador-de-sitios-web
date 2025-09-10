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
        Schema::table('websites', function (Blueprint $table) {
            // Eliminar la foreign key primero
            $table->dropForeign(['template_id']);
            // Eliminar la columna template_id actual
            $table->dropColumn('template_id');
        });
        
        Schema::table('websites', function (Blueprint $table) {
            // Agregar la columna template_id como foreignId
            $table->foreignId('template_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            // Eliminar la foreign key
            $table->dropForeign(['template_id']);
            $table->dropColumn('template_id');
        });
        
        Schema::table('websites', function (Blueprint $table) {
            // Restaurar la columna como string
            $table->string('template_id')->nullable();
        });
    }
};
