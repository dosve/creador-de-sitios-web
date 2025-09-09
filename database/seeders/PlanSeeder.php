<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Plan Gratuito',
                'description' => 'Perfecto para empezar',
                'price' => 0.00,
                'billing_cycle' => 'monthly',
                'max_websites' => 1,
                'max_pages' => 5,
                'custom_domain' => false,
                'ecommerce' => false,
                'seo_tools' => false,
                'analytics' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Plan Básico',
                'description' => 'Para proyectos pequeños',
                'price' => 9.99,
                'billing_cycle' => 'monthly',
                'max_websites' => 3,
                'max_pages' => 20,
                'custom_domain' => true,
                'ecommerce' => false,
                'seo_tools' => true,
                'analytics' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Plan Pro',
                'description' => 'Para negocios en crecimiento',
                'price' => 19.99,
                'billing_cycle' => 'monthly',
                'max_websites' => 10,
                'max_pages' => 100,
                'custom_domain' => true,
                'ecommerce' => true,
                'seo_tools' => true,
                'analytics' => true,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            \App\Models\Plan::create($plan);
        }
    }
}
