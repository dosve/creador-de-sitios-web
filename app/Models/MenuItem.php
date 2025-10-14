<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'parent_id',
        'page_id',
        'title',
        'url',
        'target',
        'icon',
        'description',
        'order',
        'is_active',
        'custom_attributes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'custom_attributes' => 'array',
    ];

    /**
     * Relación con el menú
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Relación con la página
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Relación con el item padre (para submenús)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Relación con los items hijos (submenús)
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->where('is_active', true)->orderBy('order');
    }

    /**
     * Relación con todos los items hijos (incluyendo inactivos)
     */
    public function allChildren(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    /**
     * Obtener la URL final del enlace
     */
    public function getFinalUrlAttribute(): string
    {
        // Si tiene URL personalizada, usarla
        if ($this->url) {
            return $this->url;
        }

        // Si está vinculado a una página
        if ($this->page_id && $this->page) {
            $website = $this->page->website;
            
            // Verificar si tiene dominio personalizado
            $customDomain = $website->domains()
                ->where('is_verified', true)
                ->where('status', 'active')
                ->where('is_primary', true)
                ->first();
            
            if ($customDomain) {
                // Con dominio personalizado, no usar slug del sitio
                if ($this->page->is_home) {
                    return '/';
                }
                return '/' . $this->page->slug;
            } else {
                // Sin dominio personalizado, usar slug del sitio
                $websiteSlug = $website->slug;
                
                if ($this->page->is_home) {
                    return '/' . $websiteSlug;
                }
                return '/' . $websiteSlug . '/' . $this->page->slug;
            }
        }

        return '#';
    }

    /**
     * Verificar si tiene submenús
     */
    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    /**
     * Scope para items activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para items principales (sin padre)
     */
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope para subitems
     */
    public function scopeSubItems($query)
    {
        return $query->whereNotNull('parent_id');
    }
}
