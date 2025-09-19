<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear o actualizar usuario administrador
        User::updateOrCreate(
            ['email' => 'admin@creador.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'plan_id' => null, // Los administradores no tienen plan
                'is_active' => true,
                'email_verified_at' => null, // No verificado
            ]
        );

        // Crear o actualizar usuario creador
        User::updateOrCreate(
            ['email' => 'creator@creador.com'],
            [
                'name' => 'Usuario Creador',
                'password' => Hash::make('creator123'),
                'role' => 'creator',
                'plan_id' => null, // Sin plan asignado
                'is_active' => true,
                'email_verified_at' => null, // No verificado
            ]
        );

        $this->command->info('Usuarios creados exitosamente:');
        $this->command->info('👑 Administrador: admin@creador.com / admin123');
        $this->command->info('👤 Creador: creator@creador.com / creator123');
    }
}
