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
        Schema::table('users', function (Blueprint $table) {
            // ID del usuario en Auth EME10
            $table->unsignedBigInteger('auth_eme10_id')->nullable()->after('id');
            
            // Token actual de Auth EME10
            $table->text('auth_eme10_token')->nullable()->after('password');
            
            // Número de teléfono (Auth EME10 lo soporta)
            $table->string('phone')->nullable()->after('email');
            
            // Avatar del usuario
            $table->string('avatar')->nullable()->after('phone');
            
            // Información de 2FA
            $table->boolean('two_factor_enabled')->default(false)->after('avatar');
            $table->string('two_factor_method')->nullable()->after('two_factor_enabled'); // email o sms
            
            // Sesión ID de Auth EME10
            $table->string('auth_eme10_session_id')->nullable()->after('two_factor_method');
            
            // Última sincronización con Auth EME10
            $table->timestamp('last_auth_sync')->nullable()->after('auth_eme10_session_id');
            
            // Índices para búsquedas
            $table->index('auth_eme10_id');
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['auth_eme10_id']);
            $table->dropIndex(['phone']);
            
            $table->dropColumn([
                'auth_eme10_id',
                'auth_eme10_token',
                'phone',
                'avatar',
                'two_factor_enabled',
                'two_factor_method',
                'auth_eme10_session_id',
                'last_auth_sync',
            ]);
        });
    }
};

