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
}
