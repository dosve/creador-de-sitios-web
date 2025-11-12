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
        Schema::table('pages', function (Blueprint $table) {
            if (!Schema::hasColumn('pages', 'blocks')) {
                // La tabla usa 'html_content', no 'content'
                if (Schema::hasColumn('pages', 'html_content')) {
                    $table->json('blocks')->nullable()->after('html_content');
                } else {
                    $table->json('blocks')->nullable();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'blocks')) {
                $table->dropColumn('blocks');
            }
        });
    }
};
