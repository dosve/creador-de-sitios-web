<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Esta tabla relaciona los usuarios de AdminNegocios con las tiendas.
     * Permite saber qué usuarios han comprado o iniciado sesión en una tienda específica.
     */
    public function up(): void
    {
        Schema::create('website_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('admin_negocios_user_id'); // ID del usuario en AdminNegocios
            $table->string('email')->index();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('first_login_at')->nullable(); // Primera vez que inició sesión
            $table->timestamp('last_login_at')->nullable(); // Última vez que inició sesión
            $table->timestamp('first_purchase_at')->nullable(); // Primera compra
            $table->timestamp('last_purchase_at')->nullable(); // Última compra
            $table->integer('total_orders')->default(0); // Total de órdenes
            $table->decimal('total_spent', 10, 2)->default(0); // Total gastado
            $table->timestamps();

            // Un usuario puede estar asociado a múltiples tiendas
            $table->unique(['website_id', 'admin_negocios_user_id'], 'website_user_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_customers');
    }
};

