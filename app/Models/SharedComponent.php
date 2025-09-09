<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SharedComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'name',
        'type',
        'description',
        'html_content',
        'css_content',
        'grapesjs_data',
        'settings',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'grapesjs_data' => 'array',
            'settings' => 'array',
            'is_active' => 'boolean',
        ];
    }

    // Relaciones
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Métodos de utilidad
    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'header' => 'Encabezado',
            'footer' => 'Pie de página',
            'menu' => 'Menú de navegación',
            'block' => 'Bloque reutilizable',
            default => ucfirst($this->type)
        };
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'header' => 'M4 6h16M4 12h16M4 18h16',
            'footer' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
            'menu' => 'M4 6h16M4 12h16M4 18h16',
            'block' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
            default => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
        };
    }

    public function duplicate($newName = null)
    {
        $duplicate = $this->replicate();
        $duplicate->name = $newName ?: $this->name . ' (Copia)';
        $duplicate->save();
        
        return $duplicate;
    }
}