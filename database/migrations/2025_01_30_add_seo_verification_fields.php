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
        Schema::table('seo_settings', function (Blueprint $table) {
            // Google Search Console
            $table->text('google_site_verification')->nullable()->after('google_tag_manager_id');
            $table->text('microsoft_site_verification')->nullable()->after('google_site_verification');
            
            // Imagen por defecto para Open Graph
            $table->string('default_og_image')->nullable()->after('og_image');
            
            // URL del sitemap
            $table->string('sitemap_url')->nullable()->after('canonical_url');
            
            // Índices por buscadores
            $table->boolean('allow_google_index')->default(true)->after('robots_follow');
            $table->boolean('allow_bing_index')->default(true)->after('allow_google_index');
            
            // Preferencia de móvil
            $table->enum('mobile_friendly', ['not-set', 'mobile', 'desktop', 'auto'])->default('auto')->after('allow_bing_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_settings', function (Blueprint $table) {
            $table->dropColumn([
                'google_site_verification',
                'microsoft_site_verification',
                'default_og_image',
                'sitemap_url',
                'allow_google_index',
                'allow_bing_index',
                'mobile_friendly'
            ]);
        });
    }
};
