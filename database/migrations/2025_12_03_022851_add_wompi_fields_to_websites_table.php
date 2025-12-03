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
            // Campos para integración con Wompi
            $table->string('wompi_public_key')->nullable()->after('cash_on_delivery_instructions')
                ->comment('Llave pública de Wompi');
            $table->string('wompi_private_key')->nullable()->after('wompi_public_key')
                ->comment('Llave privada de Wompi');
            $table->string('wompi_event_key')->nullable()->after('wompi_private_key')
                ->comment('Llave de eventos (webhooks) de Wompi');
            $table->string('wompi_integrity_key')->nullable()->after('wompi_event_key')
                ->comment('Llave de integridad de Wompi');
            $table->string('default_payment_gateway')->default('epayco')->after('wompi_integrity_key')
                ->comment('Pasarela de pago por defecto: epayco o wompi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn([
                'wompi_public_key',
                'wompi_private_key',
                'wompi_event_key',
                'wompi_integrity_key',
                'default_payment_gateway'
            ]);
        });
    }
};
