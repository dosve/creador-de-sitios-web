<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Domain extends Model
{
    protected $fillable = [
        'website_id',
        'domain',
        'type',
        'is_primary',
        'is_verified',
        'ssl_enabled',
        'ssl_expires_at',
        'dns_records',
        'status',
        'notes',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_verified' => 'boolean',
        'ssl_enabled' => 'boolean',
        'ssl_expires_at' => 'datetime',
        'dns_records' => 'array',
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    /**
     * Buscar dominio por host, aceptando tanto con "www." como sin él.
     * Así www.lyman.com.co y lyman.com.co resuelven al mismo sitio.
     */
    public static function findByHost(string $host): ?self
    {
        $variants = [$host];
        if (str_starts_with($host, 'www.')) {
            $variants[] = substr($host, 4);
        } else {
            $variants[] = 'www.' . $host;
        }

        return static::whereIn('domain', array_unique($variants))
            ->where('is_verified', true)
            ->where('status', 'active')
            ->first();
    }
}
