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
            // Configuración de métodos de pago
            $table->boolean('allow_cash_on_delivery')->default(true)->after('epayco_customer_id')
                ->comment('Permitir pago contra entrega');
            $table->boolean('allow_online_payment')->default(true)->after('allow_cash_on_delivery')
                ->comment('Permitir pago en línea (ePayco u otra pasarela)');
            $table->boolean('require_payment_before_shipping')->default(false)->after('allow_online_payment')
                ->comment('Requiere pago antes de enviar (solo para pagos en línea)');
            $table->text('cash_on_delivery_instructions')->nullable()->after('require_payment_before_shipping')
                ->comment('Instrucciones adicionales para pago contra entrega');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn([
                'allow_cash_on_delivery',
                'allow_online_payment',
                'require_payment_before_shipping',
                'cash_on_delivery_instructions'
            ]);
        });
    }
};
