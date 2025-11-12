<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplateConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'template_slug',
        'configuration',
        'customization',
        'settings',
        'is_active'
    ];

    protected $casts = [
        'configuration' => 'array',
        'customization' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Relación con Website
     */
    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    /**
     * Obtiene la configuración por defecto de una plantilla
     */
    public static function getDefaultConfiguration(string $templateSlug): array
    {
        $configPath = resource_path("views/templates/{$templateSlug}/config.json");
        
        if (file_exists($configPath)) {
            return json_decode(file_get_contents($configPath), true);
        }

        return [
            'name' => ucfirst(str_replace('-', ' ', $templateSlug)),
            'slug' => $templateSlug,
            'description' => 'Plantilla personalizable',
            'category' => 'basic',
            'customization' => [
                'colors' => [
                    'primary' => '#3b82f6',
                    'secondary' => '#1f2937',
                    'accent' => '#10b981',
                    'background' => '#ffffff',
                    'text' => '#111827'
                ],
                'fonts' => [
                    'heading' => 'Inter, sans-serif',
                    'body' => 'Inter, sans-serif'
                ],
                'layout' => [
                    'container_width' => '1200px'
                ]
            ]
        ];
    }

    /**
     * Obtiene la configuración completa de una plantilla
     */
    public function getFullConfiguration(): array
    {
        $defaultConfig = self::getDefaultConfiguration($this->template_slug);
        
        return array_merge_recursive(
            $defaultConfig,
            $this->configuration ?? [],
            $this->customization ?? [],
            $this->settings ?? []
        );
    }

    /**
     * Actualiza la configuración de una plantilla
     */
    public function updateConfiguration(array $configuration): void
    {
        $this->update(['configuration' => $configuration]);
    }

    /**
     * Actualiza la personalización de una plantilla
     */
    public function updateCustomization(array $customization): void
    {
        $this->update(['customization' => $customization]);
    }

    /**
     * Actualiza la configuración general de una plantilla
     */
    public function updateSettings(array $settings): void
    {
        $this->update(['settings' => $settings]);
    }

    /**
     * Obtiene o crea la configuración de una plantilla para un sitio web
     */
    public static function getOrCreateForWebsite(int $websiteId, string $templateSlug): self
    {
        return self::firstOrCreate(
            [
                'website_id' => $websiteId,
                'template_slug' => $templateSlug
            ],
            [
                'configuration' => self::getDefaultConfiguration($templateSlug),
                'customization' => [],
                'settings' => []
            ]
        );
    }
}
