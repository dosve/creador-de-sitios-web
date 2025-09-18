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
            $table->string('epayco_public_key')->nullable()->after('api_base_url');
            $table->string('epayco_private_key')->nullable()->after('epayco_public_key');
            $table->string('epayco_customer_id')->nullable()->after('epayco_private_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn(['epayco_public_key', 'epayco_private_key', 'epayco_customer_id']);
        });
    }
};
