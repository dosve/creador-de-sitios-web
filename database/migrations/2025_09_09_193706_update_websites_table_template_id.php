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
            // Cambiar template_id de string a foreignId
            $table->dropColumn('template_id');
        });
        
        Schema::table('websites', function (Blueprint $table) {
            $table->foreignId('template_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
            $table->dropColumn('template_id');
        });
        
        Schema::table('websites', function (Blueprint $table) {
            $table->string('template_id')->nullable();
        });
    }
};