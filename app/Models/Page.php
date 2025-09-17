<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'title',
        'slug',
        'meta_description',
        'html_content',
        'css_content',
        'grapesjs_data',
        'is_published',
        'is_home',
        'enable_store',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_home' => 'boolean',
            'enable_store' => 'boolean',
            'grapesjs_data' => 'array',
        ];
    }

    // Relaciones
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function versions()
    {
        return $this->hasMany(PageVersion::class)->latest();
    }

    public function latestVersion()
    {
        return $this->hasOne(PageVersion::class)->latest();
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    // Métodos de utilidad
    public function createVersion($changeDescription = null)
    {
        $versionNumber = $this->versions()->count() + 1;

        return $this->versions()->create([
            'user_id' => auth()->id(),
            'version_number' => $versionNumber,
            'title' => $this->title,
            'slug' => $this->slug,
            'meta_description' => $this->meta_description,
            'html_content' => $this->html_content,
            'css_content' => $this->css_content,
            'grapesjs_data' => $this->grapesjs_data,
            'is_published' => $this->is_published,
            'change_description' => $changeDescription,
        ]);
    }

    public function restoreFromVersion(PageVersion $version)
    {
        $this->update([
            'title' => $version->title,
            'slug' => $version->slug,
            'meta_description' => $version->meta_description,
            'html_content' => $version->html_content,
            'css_content' => $version->css_content,
            'grapesjs_data' => $version->grapesjs_data,
            'is_published' => $version->is_published,
        ]);

        // Crear una nueva versión con el contenido restaurado
        $this->createVersion("Restaurado desde la versión {$version->version_number}");
    }
}
