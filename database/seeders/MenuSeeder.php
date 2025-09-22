<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Website;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $websites = Website::all();

        foreach ($websites as $website) {
            $this->createMenusForWebsite($website);
        }
    }

    private function createMenusForWebsite(Website $website)
    {
        // Crear menú principal (header)
        $mainMenu = Menu::create([
            'website_id' => $website->id,
            'name' => 'Menú Principal',
            'location' => 'header',
            'description' => 'Menú de navegación principal del sitio web',
            'is_active' => true,
        ]);

        // Crear menú footer
        $footerMenu = Menu::create([
            'website_id' => $website->id,
            'name' => 'Menú Footer',
            'location' => 'footer',
            'description' => 'Enlaces del pie de página',
            'is_active' => true,
        ]);

        // Obtener páginas del sitio web
        $pages = $website->pages()->where('is_published', true)->get();
        $homePage = $pages->where('is_home', true)->first();

        // Items para el menú principal
        $mainMenuItems = [
            [
                'title' => 'Inicio',
                'icon' => '🏠',
                'page_id' => $homePage ? $homePage->id : null,
                'url' => $homePage ? null : '/',
                'order' => 1,
            ],
            [
                'title' => 'Productos',
                'icon' => '🛍️',
                'url' => '/productos',
                'order' => 2,
            ],
            [
                'title' => 'Tienda',
                'icon' => '🛒',
                'url' => '/tienda',
                'order' => 3,
            ],
            [
                'title' => 'Blog',
                'icon' => '📝',
                'url' => '/blog',
                'order' => 4,
            ],
            [
                'title' => 'Contacto',
                'icon' => '📧',
                'url' => '/contacto',
                'order' => 5,
            ],
        ];

        foreach ($mainMenuItems as $itemData) {
            MenuItem::create(array_merge($itemData, [
                'menu_id' => $mainMenu->id,
                'target' => '_self',
                'is_active' => true,
            ]));
        }

        // Items para el menú footer
        $footerMenuItems = [
            [
                'title' => 'Política de Privacidad',
                'url' => '/politica-privacidad',
                'order' => 1,
            ],
            [
                'title' => 'Términos y Condiciones',
                'url' => '/terminos-condiciones',
                'order' => 2,
            ],
            [
                'title' => 'Facebook',
                'url' => 'https://facebook.com',
                'target' => '_blank',
                'icon' => '📘',
                'order' => 3,
            ],
            [
                'title' => 'Instagram',
                'url' => 'https://instagram.com',
                'target' => '_blank',
                'icon' => '📷',
                'order' => 4,
            ],
            [
                'title' => 'WhatsApp',
                'url' => 'https://wa.me/1234567890',
                'target' => '_blank',
                'icon' => '💬',
                'order' => 5,
            ],
        ];

        foreach ($footerMenuItems as $itemData) {
            MenuItem::create(array_merge($itemData, [
                'menu_id' => $footerMenu->id,
                'target' => $itemData['target'] ?? '_self',
                'is_active' => true,
            ]));
        }

        // Crear submenú de ejemplo para "Productos"
        $productosItem = $mainMenu->items()->where('title', 'Productos')->first();
        if ($productosItem) {
            $subItems = [
                [
                    'title' => 'Categoría 1',
                    'url' => '/categoria/1',
                    'order' => 1,
                ],
                [
                    'title' => 'Categoría 2',
                    'url' => '/categoria/2',
                    'order' => 2,
                ],
                [
                    'title' => 'Ofertas',
                    'url' => '/ofertas',
                    'order' => 3,
                ],
            ];

            foreach ($subItems as $subItemData) {
                MenuItem::create(array_merge($subItemData, [
                    'menu_id' => $mainMenu->id,
                    'parent_id' => $productosItem->id,
                    'target' => '_self',
                    'is_active' => true,
                ]));
            }
        }
    }
}
