<?php

namespace App\Helpers;

use App\Models\Website;
use App\Models\SeoSettings;
use Illuminate\Support\Facades\URL;

class SeoHelper
{
    /**
     * Generar meta tags dinámicos para SEO
     */
    public static function generateMetaTags(Website $website, $page = null, $custom = [])
    {
        $seoSettings = $website->seoSettings ?? new SeoSettings();
        
        // Obtener datos básicos
        $title = $custom['title'] ?? $seoSettings->meta_title ?? $website->name ?? config('app.name');
        $description = $custom['description'] ?? $seoSettings->meta_description ?? $website->description ?? '';
        $keywords = $custom['keywords'] ?? $seoSettings->meta_keywords ?? '';
        $url = $custom['url'] ?? self::getCurrentUrl();
        $image = $custom['image'] ?? $seoSettings->og_image ?? $seoSettings->default_og_image ?? self::getDefaultImage();
        
        // Limitar a máximos recomendados
        $title = self::limitString($title, 60);
        $description = self::limitString($description, 160);
        
        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'canonical_url' => $custom['canonical'] ?? $seoSettings->canonical_url ?? $url,
            'og' => [
                'title' => $custom['og_title'] ?? $seoSettings->og_title ?? $title,
                'description' => $custom['og_description'] ?? $seoSettings->og_description ?? $description,
                'image' => $image,
                'url' => $url,
                'type' => $custom['og_type'] ?? 'website',
            ],
            'twitter' => [
                'card' => $seoSettings->twitter_card ?? 'summary_large_image',
                'site' => $seoSettings->twitter_site ?? '',
                'creator' => $seoSettings->twitter_creator ?? '',
                'title' => $custom['og_title'] ?? $seoSettings->og_title ?? $title,
                'description' => $custom['og_description'] ?? $seoSettings->og_description ?? $description,
            ],
            'robots' => self::generateRobotsMeta($seoSettings),
            'verification' => [
                'google' => $seoSettings->google_site_verification ?? '',
                'microsoft' => $seoSettings->microsoft_site_verification ?? '',
            ]
        ];
    }

    /**
     * Generar contenido del meta tag robots
     */
    public static function generateRobotsMeta(SeoSettings $seoSettings)
    {
        $robots = [];
        
        if (!$seoSettings->robots_index) {
            $robots[] = 'noindex';
        }
        
        if (!$seoSettings->robots_follow) {
            $robots[] = 'nofollow';
        }
        
        return empty($robots) ? 'index, follow' : implode(', ', $robots);
    }

    /**
     * Obtener URL actual completa y correcta
     */
    public static function getCurrentUrl()
    {
        $protocol = request()->getScheme();
        $host = request()->getHost();
        $path = request()->getPath();
        
        return $protocol . '://' . $host . '/' . ltrim($path, '/');
    }

    /**
     * Obtener imagen por defecto
     */
    public static function getDefaultImage()
    {
        // Buscar imagen en storage/app/public/default-og-image
        $defaultImages = [
            '/storage/images/default-og-image.jpg',
            '/storage/images/default-og-image.png',
            '/images/default-og.jpg',
        ];
        
        foreach ($defaultImages as $image) {
            if (file_exists(public_path($image))) {
                return url($image);
            }
        }
        
        // Imagen placeholder por defecto
        return 'https://via.placeholder.com/1200x630?text=Sitio+Web';
    }

    /**
     * Limitar string a cierta longitud
     */
    public static function limitString($string, $limit = 160)
    {
        if (strlen($string) <= $limit) {
            return $string;
        }
        
        return substr($string, 0, $limit) . '...';
    }

    /**
     * Generar JSON-LD para esquema estructurado
     */
    public static function generateSchemaMarkup(Website $website, $type = 'Organization')
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => $type,
            'name' => $website->name,
            'description' => $website->description,
            'url' => self::getDomainUrl($website),
        ];
        
        if ($website->logo_url) {
            $schema['logo'] = $website->logo_url;
        }
        
        if ($website->phone) {
            $schema['telephone'] = $website->phone;
        }
        
        if ($website->email) {
            $schema['email'] = $website->email;
        }
        
        if ($website->address) {
            $schema['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $website->address,
            ];
        }
        
        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Obtener URL del dominio
     */
    public static function getDomainUrl(Website $website)
    {
        if ($website->domain && $website->domain->is_verified) {
            return 'https://' . $website->domain->domain;
        }
        
        return url('/');
    }
}
