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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained()->onDelete('cascade');
            $table->string('domain')->unique();
            $table->string('type')->default('subdomain'); // subdomain, custom
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->boolean('ssl_enabled')->default(false);
            $table->timestamp('ssl_expires_at')->nullable();
            $table->json('dns_records')->nullable(); // DNS configuration
            $table->string('status')->default('pending'); // pending, active, suspended
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['website_id', 'is_primary']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
