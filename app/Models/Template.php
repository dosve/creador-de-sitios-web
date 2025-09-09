<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'preview_images',
        'html_content',
        'css_content',
        'blocks',
        'is_premium',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'preview_images' => 'array',
            'blocks' => 'array',
            'is_premium' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    // Relaciones
    public function websites()
    {
        return $this->hasMany(Website::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFree($query)
    {
        return $query->where('is_premium', false);
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
