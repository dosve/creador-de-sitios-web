<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Website;
use App\Models\BlogPost;
use App\Models\Category;

class CreateSampleProducts extends Command
{
    protected $signature = 'products:create-sample {website_id}';
    protected $description = 'Crea productos de ejemplo para un sitio web';

    public function handle()
    {
        $websiteId = $this->argument('website_id');
        $website = Website::find($websiteId);

        if (!$website) {
            $this->error("Sitio web con ID {$websiteId} no encontrado.");
            return 1;
        }

        $this->info("Creando productos de ejemplo para: {$website->name}");

        // Crear categorías de ejemplo si no existen
        $categories = [
            ['name' => 'Electrónicos', 'description' => 'Dispositivos electrónicos y tecnología'],
            ['name' => 'Ropa', 'description' => 'Vestimenta y accesorios'],
            ['name' => 'Hogar', 'description' => 'Artículos para el hogar'],
        ];

        $createdCategories = [];
        foreach ($categories as $catData) {
            $category = Category::firstOrCreate(
                ['name' => $catData['name'], 'website_id' => $website->id],
                [
                    'description' => $catData['description'],
                    'is_active' => true,
                    'slug' => \Str::slug($catData['name'])
                ]
            );
            $createdCategories[] = $category;
            $this->line("✓ Categoría creada: {$category->name}");
        }

        // Crear productos de ejemplo
        $products = [
            [
                'title' => 'Smartphone Samsung Galaxy',
                'content' => 'Smartphone de última generación con pantalla AMOLED de 6.1 pulgadas, cámara de 64MP y batería de larga duración.',
                'price' => 899.99,
                'stock' => 25,
                'sku' => 'SMS-GAL-001',
                'category' => 'Electrónicos'
            ],
            [
                'title' => 'Laptop HP Pavilion',
                'content' => 'Laptop ideal para trabajo y entretenimiento. Procesador Intel i5, 8GB RAM, 256GB SSD.',
                'price' => 1299.99,
                'stock' => 15,
                'sku' => 'HP-PAV-002',
                'category' => 'Electrónicos'
            ],
            [
                'title' => 'Camiseta Básica Algodón',
                'content' => 'Camiseta 100% algodón, cómoda y versátil. Disponible en varios colores.',
                'price' => 19.99,
                'stock' => 100,
                'sku' => 'CAM-BAS-003',
                'category' => 'Ropa'
            ],
            [
                'title' => 'Jeans Clásicos',
                'content' => 'Jeans de corte clásico, tela resistente y cómoda. Perfectos para cualquier ocasión.',
                'price' => 49.99,
                'stock' => 50,
                'sku' => 'JEA-CLA-004',
                'category' => 'Ropa'
            ],
            [
                'title' => 'Set de Ollas Antiadherentes',
                'content' => 'Set de 5 ollas antiadherentes de alta calidad. Incluye sartenes de diferentes tamaños.',
                'price' => 79.99,
                'stock' => 30,
                'sku' => 'OLL-ANT-005',
                'category' => 'Hogar'
            ],
            [
                'title' => 'Aspiradora Inalámbrica',
                'content' => 'Aspiradora inalámbrica de alta potencia. Batería de larga duración y fácil de usar.',
                'price' => 199.99,
                'stock' => 20,
                'sku' => 'ASP-INA-006',
                'category' => 'Hogar'
            ]
        ];

        foreach ($products as $productData) {
            $category = collect($createdCategories)->firstWhere('name', $productData['category']);
            
            $product = BlogPost::create([
                'website_id' => $website->id,
                'title' => $productData['title'],
                'slug' => \Str::slug($productData['title']),
                'content' => $productData['content'],
                'excerpt' => \Str::limit($productData['content'], 150),
                'is_published' => true,
                'is_product' => true,
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'sku' => $productData['sku'],
                'category_id' => $category->id,
                'meta_title' => $productData['title'],
                'meta_description' => \Str::limit($productData['content'], 160),
            ]);

            $this->line("✓ Producto creado: {$product->title} - \${$product->price}");
        }

        $this->info("¡Productos de ejemplo creados exitosamente!");
        $this->line("Total de productos: " . count($products));
        $this->line("Total de categorías: " . count($createdCategories));

        return 0;
    }
}