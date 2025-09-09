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
        Schema::create('media_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained()->onDelete('cascade');
            $table->string('original_name');
            $table->string('filename');
            $table->string('file_path');
            $table->string('file_url');
            $table->string('mime_type');
            $table->string('file_type'); // image, document, video, audio, other
            $table->bigInteger('file_size'); // en bytes
            $table->integer('width')->nullable(); // para imágenes
            $table->integer('height')->nullable(); // para imágenes
            $table->string('alt_text')->nullable(); // para accesibilidad
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // metadatos adicionales
            $table->boolean('is_public')->default(true);
            $table->timestamps();
            
            $table->index(['website_id', 'file_type']);
            $table->index(['website_id', 'is_public']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_files');
    }
};
