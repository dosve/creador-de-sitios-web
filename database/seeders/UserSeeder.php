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
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@creador-sitios.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'plan_id' => null, // Los administradores no tienen plan
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Crear usuario creador
        User::create([
            'name' => 'Usuario Creador',
            'email' => 'creator@creador-sitios.com',
            'password' => Hash::make('creator123'),
            'role' => 'creator',
            'plan_id' => 1, // Plan gratuito
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Usuarios creados exitosamente:');
        $this->command->info('👑 Administrador: admin@creador-sitios.com / admin123');
        $this->command->info('👤 Creador: creator@creador-sitios.com / creator123');
    }
}
