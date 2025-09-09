<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'billing_cycle',
        'max_websites',
        'max_pages',
        'custom_domain',
        'ecommerce',
        'seo_tools',
        'analytics',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'custom_domain' => 'boolean',
            'ecommerce' => 'boolean',
            'seo_tools' => 'boolean',
            'analytics' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    // Relaciones
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
