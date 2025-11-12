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
            // Logo y favicon
            $table->string('logo')->nullable()->after('subdomain');
            $table->string('favicon')->nullable()->after('logo');
            
            // URLs de redes sociales
            $table->string('facebook_url')->nullable()->after('epayco_customer_id');
            $table->string('instagram_url')->nullable()->after('facebook_url');
            $table->string('twitter_url')->nullable()->after('instagram_url');
            $table->string('linkedin_url')->nullable()->after('twitter_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn([
                'logo',
                'favicon',
                'facebook_url',
                'instagram_url',
                'twitter_url',
                'linkedin_url'
            ]);
        });
    }
};
