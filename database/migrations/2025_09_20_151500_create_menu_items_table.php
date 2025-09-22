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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->onDelete('cascade');
            $table->foreignId('page_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title'); // Texto del enlace
            $table->string('url')->nullable(); // URL personalizada
            $table->string('target')->default('_self'); // _self, _blank
            $table->string('icon')->nullable(); // Icono (opcional)
            $table->text('description')->nullable(); // Descripción del enlace
            $table->integer('order')->default(0); // Orden de aparición
            $table->boolean('is_active')->default(true);
            $table->json('custom_attributes')->nullable(); // Atributos HTML personalizados
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
