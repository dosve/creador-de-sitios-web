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
        Schema::table('media_files', function (Blueprint $table) {
            // Verificar si las columnas no existen antes de agregarlas
            if (!Schema::hasColumn('media_files', 'original_name')) {
                $table->string('original_name')->after('website_id');
            }
            if (!Schema::hasColumn('media_files', 'file_url')) {
                $table->string('file_url')->after('file_path');
            }
            if (!Schema::hasColumn('media_files', 'file_type')) {
                $table->string('file_type')->after('mime_type')->comment('image, document, video, audio, other');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media_files', function (Blueprint $table) {
            if (Schema::hasColumn('media_files', 'original_name')) {
                $table->dropColumn('original_name');
            }
            if (Schema::hasColumn('media_files', 'file_url')) {
                $table->dropColumn('file_url');
            }
            if (Schema::hasColumn('media_files', 'file_type')) {
                $table->dropColumn('file_type');
            }
        });
    }
};
