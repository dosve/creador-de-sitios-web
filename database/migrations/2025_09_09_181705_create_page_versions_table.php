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
        Schema::create('page_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('version_number');
            $table->string('title');
            $table->string('slug');
            $table->text('meta_description')->nullable();
            $table->longText('html_content');
            $table->longText('css_content')->nullable();
            $table->longText('grapesjs_data')->nullable();
            $table->boolean('is_published')->default(false);
            $table->text('change_description')->nullable();
            $table->timestamps();
            
            $table->index(['page_id', 'version_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_versions');
    }
};
