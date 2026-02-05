<?php

namespace App\Services;

use App\Models\Website;
use App\Models\Page;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\BlogPost;
use App\Models\BlogPostTag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DuplicateWebsiteService
{
    /**
     * Duplicar un sitio web completo con todas sus páginas, categorías, etiquetas y contenido
     */
    public function duplicate(Website $originalWebsite, string $newName, ?string $newSlug = null): Website
    {
        return DB::transaction(function () use ($originalWebsite, $newName, $newSlug) {
            // 1. Crear el nuevo sitio web
            $newSlug = $newSlug ?? Str::slug($newName);
            
            // Asegurar que el slug sea único
            $newSlug = $this->generateUniqueSlug($newSlug);
            
            $newWebsite = Website::create([
                'user_id' => $originalWebsite->user_id,
                'name' => $newName,
                'slug' => $newSlug,
                'description' => $originalWebsite->description,
                'template_id' => $originalWebsite->template_id,
                'is_published' => false, // El nuevo sitio empieza no publicado
                'settings' => $originalWebsite->settings,
                'seo_settings' => $originalWebsite->seo_settings,
                'logo' => $this->duplicateImage($originalWebsite->logo),
                'favicon' => $this->duplicateImage($originalWebsite->favicon),
                'api_key' => $originalWebsite->api_key,
                'api_base_url' => $originalWebsite->api_base_url,
                'epayco_public_key' => $originalWebsite->epayco_public_key,
                'epayco_private_key' => $originalWebsite->epayco_private_key,
                'epayco_customer_id' => $originalWebsite->epayco_customer_id,
                'allow_cash_on_delivery' => $originalWebsite->allow_cash_on_delivery,
                'allow_online_payment' => $originalWebsite->allow_online_payment,
                'require_payment_before_shipping' => $originalWebsite->require_payment_before_shipping,
                'cash_on_delivery_instructions' => $originalWebsite->cash_on_delivery_instructions,
                'wompi_public_key' => $originalWebsite->wompi_public_key,
                'wompi_private_key' => $originalWebsite->wompi_private_key,
                'wompi_event_key' => $originalWebsite->wompi_event_key,
                'wompi_integrity_key' => $originalWebsite->wompi_integrity_key,
                'default_payment_gateway' => $originalWebsite->default_payment_gateway,
                'facebook_url' => $originalWebsite->facebook_url,
                'instagram_url' => $originalWebsite->instagram_url,
                'twitter_url' => $originalWebsite->twitter_url,
                'linkedin_url' => $originalWebsite->linkedin_url,
            ]);

            // 2. Duplicar categorías
            $categoriesMap = [];
            foreach ($originalWebsite->categories as $originalCategory) {
                $newCategory = Category::create([
                    'website_id' => $newWebsite->id,
                    'name' => $originalCategory->name,
                    'slug' => $this->generateUniqueCategorySlug($originalCategory->slug, $newWebsite->id),
                    'description' => $originalCategory->description,
                    'image' => $this->duplicateImage($originalCategory->image),
                ]);
                $categoriesMap[$originalCategory->id] = $newCategory->id;
            }

            // 3. Duplicar etiquetas
            $tagsMap = [];
            foreach ($originalWebsite->tags as $originalTag) {
                $newTag = Tag::create([
                    'website_id' => $newWebsite->id,
                    'name' => $originalTag->name,
                    'slug' => $this->generateUniqueTagSlug($originalTag->slug, $newWebsite->id),
                ]);
                $tagsMap[$originalTag->id] = $newTag->id;
            }

            // 4. Duplicar páginas
            $pagesMap = [];
            foreach ($originalWebsite->pages as $originalPage) {
                $pageData = [
                    'website_id' => $newWebsite->id,
                    'title' => $originalPage->title,
                    'slug' => $this->generateUniquePageSlug($originalPage->slug, $newWebsite->id),
                    'is_published' => $originalPage->is_published, // Mantener el estado original
                    'is_home' => $originalPage->is_home,
                    'sort_order' => $originalPage->sort_order,
                ];
                
                // Agregar columnas opcionales solo si existen en el modelo original
                $optionalColumns = [
                    'html_content', 'css_content', 'grapesjs_data', 'blocks',
                    'meta_description', 'enable_store', 'content'
                ];
                
                foreach ($optionalColumns as $column) {
                    if (isset($originalPage->$column)) {
                        $pageData[$column] = $originalPage->$column;
                    }
                }
                
                $newPage = Page::create($pageData);
                $pagesMap[$originalPage->id] = $newPage->id;
            }

            // 5. Duplicar posts del blog
            $blogPostsMap = [];
            foreach ($originalWebsite->blogPosts as $originalBlogPost) {
                $newBlogPost = BlogPost::create([
                    'website_id' => $newWebsite->id,
                    'category_id' => $originalBlogPost->category_id ? ($categoriesMap[$originalBlogPost->category_id] ?? null) : null,
                    'title' => $originalBlogPost->title,
                    'slug' => $this->generateUniqueBlogPostSlug($originalBlogPost->slug, $newWebsite->id),
                    'excerpt' => $originalBlogPost->excerpt,
                    'content' => $originalBlogPost->content,
                    'featured_image' => $this->duplicateImage($originalBlogPost->featured_image),
                    'published_at' => $originalBlogPost->published_at,
                    'views_count' => 0,
                ]);
                $blogPostsMap[$originalBlogPost->id] = $newBlogPost->id;

                // Duplicar etiquetas del post
                if ($originalBlogPost->tags()->exists()) {
                    $newTagIds = [];
                    foreach ($originalBlogPost->tags as $originalTag) {
                        if (isset($tagsMap[$originalTag->id])) {
                            $newTagIds[] = $tagsMap[$originalTag->id];
                        }
                    }
                    if (!empty($newTagIds)) {
                        $newBlogPost->tags()->sync($newTagIds);
                    }
                }
            }

            // 6. Duplicar menús
            foreach ($originalWebsite->menus as $originalMenu) {
                $menuData = [
                    'website_id' => $newWebsite->id,
                    'name' => $originalMenu->name,
                ];
                
                // Copiar columnas opcionales si existen
                $optionalMenuColumns = ['location', 'is_active', 'description'];
                foreach ($optionalMenuColumns as $column) {
                    if (isset($originalMenu->$column)) {
                        $menuData[$column] = $originalMenu->$column;
                    }
                }
                
                $newMenu = Menu::create($menuData);

                // Duplicar items del menú
                foreach ($originalMenu->items as $originalMenuItem) {
                    $menuItemData = [
                        'menu_id' => $newMenu->id,
                        'title' => $originalMenuItem->title ?? $originalMenuItem->label ?? 'Item',
                        'parent_id' => null, // Se actualizarán después de crear todos los items
                    ];
                    
                    // Copiar columnas opcionales si existen
                    $optionalItemColumns = ['url', 'page_id', 'order', 'target', 'icon', 'description', 'is_active', 'custom_attributes'];
                    foreach ($optionalItemColumns as $column) {
                        if ($column === 'page_id' && isset($originalMenuItem->$column)) {
                            $menuItemData[$column] = $pagesMap[$originalMenuItem->$column] ?? null;
                        } elseif (isset($originalMenuItem->$column)) {
                            $menuItemData[$column] = $originalMenuItem->$column;
                        }
                    }
                    
                    MenuItem::create($menuItemData);
                }
            }

            // 7. Duplicar componentes compartidos si existen
            if (method_exists($originalWebsite, 'sharedComponents')) {
                foreach ($originalWebsite->sharedComponents as $originalComponent) {
                    \App\Models\SharedComponent::create([
                        'website_id' => $newWebsite->id,
                        'name' => $originalComponent->name,
                        'slug' => $this->generateUniqueComponentSlug($originalComponent->slug, $newWebsite->id),
                        'content' => $originalComponent->content,
                    ]);
                }
            }

            return $newWebsite;
        });
    }

    /**
     * Generar un slug único para el sitio web
     */
    private function generateUniqueSlug(string $slug): string
    {
        $originalSlug = $slug;
        $count = 1;

        while (Website::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Generar un slug único para categorías
     */
    private function generateUniqueCategorySlug(string $slug, int $websiteId): string
    {
        $originalSlug = $slug;
        $count = 1;

        while (Category::where('website_id', $websiteId)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Generar un slug único para etiquetas
     */
    private function generateUniqueTagSlug(string $slug, int $websiteId): string
    {
        $originalSlug = $slug;
        $count = 1;

        while (Tag::where('website_id', $websiteId)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Generar un slug único para páginas
     */
    private function generateUniquePageSlug(string $slug, int $websiteId): string
    {
        $originalSlug = $slug;
        $count = 1;

        while (Page::where('website_id', $websiteId)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Generar un slug único para posts del blog
     */
    private function generateUniqueBlogPostSlug(string $slug, int $websiteId): string
    {
        $originalSlug = $slug;
        $count = 1;

        while (BlogPost::where('website_id', $websiteId)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }



    /**
     * Generar un slug único para componentes compartidos
     */
    private function generateUniqueComponentSlug(string $slug, int $websiteId): string
    {
        $originalSlug = $slug;
        $count = 1;

        while (\App\Models\SharedComponent::where('website_id', $websiteId)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Duplicar una imagen física en el storage
     */
    private function duplicateImage(?string $imagePath): ?string
    {
        if (empty($imagePath)) {
            return null;
        }

        // Verificar si el archivo existe en el disco público
        if (!Storage::disk('public')->exists($imagePath)) {
            return $imagePath; // Retornar la ruta original si no existe
        }

        // Obtener información del archivo
        $pathInfo = pathinfo($imagePath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'] ?? '';

        // Generar un nuevo nombre único
        $newFilename = $filename . '_' . time() . '_' . Str::random(8);
        $newPath = $directory . '/' . $newFilename . ($extension ? '.' . $extension : '');

        // Copiar el archivo
        try {
            Storage::disk('public')->copy($imagePath, $newPath);
            return $newPath;
        } catch (\Exception $e) {
            // Si falla la copia, retornar la ruta original
            return $imagePath;
        }
    }
}
