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
            // Eliminar la foreign key constraint si existe
            try {
                $table->dropForeign(['template_id']);
            } catch (\Exception $e) {
                // Si no existe, continuar
            }
            
            // Eliminar la columna actual
            $table->dropColumn('template_id');
        });
        
        Schema::table('websites', function (Blueprint $table) {
            // Agregar template_id como string para guardar el slug
            $table->string('template_id')->nullable()->after('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn('template_id');
        });
        
        Schema::table('websites', function (Blueprint $table) {
            // Restaurar como foreign key
            $table->foreignId('template_id')->nullable()->constrained()->onDelete('set null');
        });
    }
};

