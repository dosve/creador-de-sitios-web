<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'user_id',
        'version_number',
        'title',
        'slug',
        'meta_description',
        'html_content',
        'css_content',
        'grapesjs_data',
        'is_published',
        'change_description',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'grapesjs_data' => 'array',
        ];
    }

    // Relaciones
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByVersion($query, $versionNumber)
    {
        return $query->where('version_number', $versionNumber);
    }
}