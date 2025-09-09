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
        Schema::create('shared_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // header, footer, menu, block
            $table->text('description')->nullable();
            $table->longText('html_content');
            $table->longText('css_content')->nullable();
            $table->longText('grapesjs_data')->nullable();
            $table->json('settings')->nullable(); // configuraciones específicas del componente
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['website_id', 'type']);
            $table->index(['website_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shared_components');
    }
};
