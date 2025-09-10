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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained()->onDelete('cascade');
            $table->foreignId('blog_post_id')->nullable()->constrained()->onDelete('cascade'); // Para formularios específicos de blog posts
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->enum('type', ['general', 'contact', 'newsletter', 'comment', 'survey', 'custom'])->default('general');
            $table->json('settings')->nullable(); // Configuraciones del formulario
            $table->json('email_settings')->nullable(); // Configuración de notificaciones por email
            $table->boolean('is_active')->default(true);
            $table->boolean('show_title')->default(true);
            $table->boolean('show_description')->default(true);
            $table->string('submit_button_text')->default('Enviar');
            $table->string('success_message')->default('¡Formulario enviado exitosamente!');
            $table->string('error_message')->default('Hubo un error al enviar el formulario.');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['website_id', 'is_active']);
            $table->index(['blog_post_id', 'is_active']);
            $table->unique(['website_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};