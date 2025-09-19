<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Website;

class WebsiteSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Crear o actualizar website basado en el estado actual de la base de datos
    Website::updateOrCreate(
      ['slug' => 'sitio'], // Condición de búsqueda
      [
        'name' => 'sitio',
        'description' => 'web',
        'domain' => null,
        'user_id' => 2, // Usuario Creador
        'template_id' => null, // No tiene template asignado en la DB actual
        'is_published' => false, // No publicado en la DB actual
        'api_key' => 'sk_P4AtDckEiZrNqXK60zlK1Y0NAhK6Ga0mK78MM2hW',
        'api_base_url' => 'https://servidor.adminnegocios.com/api',
        'epayco_public_key' => '9c4e7500d0c44f1acf14cd573af25255',
        'epayco_private_key' => '6d00dee4b43a02f49aa47249551e3aa9',
        'epayco_customer_id' => '499604',
      ]
    );

    $this->command->info('Website creado exitosamente:');
    $this->command->info('🌐 sitio (Usuario: 2)');
  }
}
