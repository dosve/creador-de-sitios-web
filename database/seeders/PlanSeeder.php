<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'id' => 1,
                'name' => 'Gratuito',
                'description' => 'Plan gratuito para comenzar',
                'price' => 0,
                'billing_cycle' => 'monthly',
                'max_websites' => 1,
                'max_pages' => 5,
                'custom_domain' => false,
                'ecommerce' => false,
                'seo_tools' => false,
                'analytics' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Básico',
                'description' => 'Plan básico para pequeñas empresas',
                'price' => 9.99,
                'billing_cycle' => 'monthly',
                'max_websites' => 3,
                'max_pages' => 20,
                'custom_domain' => true,
                'ecommerce' => false,
                'seo_tools' => true,
                'analytics' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Profesional',
                'description' => 'Plan profesional con todas las funcionalidades',
                'price' => 29.99,
                'billing_cycle' => 'monthly',
                'max_websites' => 10,
                'max_pages' => 100,
                'custom_domain' => true,
                'ecommerce' => true,
                'seo_tools' => true,
                'analytics' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Empresarial',
                'description' => 'Plan empresarial sin límites',
                'price' => 99.99,
                'billing_cycle' => 'monthly',
                'max_websites' => 999,
                'max_pages' => 999,
                'custom_domain' => true,
                'ecommerce' => true,
                'seo_tools' => true,
                'analytics' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('plans')->insert($plans);
    }
}

