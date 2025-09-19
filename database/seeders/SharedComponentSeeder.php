<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Website;
use App\Models\SharedComponent;

class SharedComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear o actualizar el componente que está actualmente en la base de datos
        SharedComponent::updateOrCreate(
            ['name' => 'Test Component', 'website_id' => 1],
            [
                'type' => 'header',
                'description' => 'Componente de prueba',
                'html_content' => '<div>Test</div>',
                'css_content' => 'div { color: red; }',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        $this->command->info('Shared Component creado exitosamente:');
        $this->command->info('🧩 Test Component (Website: 1, Tipo: header)');
    }
}
