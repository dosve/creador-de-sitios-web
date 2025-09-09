<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class MediaFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'original_name',
        'filename',
        'file_path',
        'file_url',
        'mime_type',
        'file_type',
        'file_size',
        'width',
        'height',
        'alt_text',
        'description',
        'metadata',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
            'metadata' => 'array',
            'is_public' => 'boolean',
        ];
    }

    // Relaciones
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    // Scopes
    public function scopeImages($query)
    {
        return $query->where('file_type', 'image');
    }

    public function scopeDocuments($query)
    {
        return $query->where('file_type', 'document');
    }

    public function scopeVideos($query)
    {
        return $query->where('file_type', 'video');
    }

    public function scopeAudios($query)
    {
        return $query->where('file_type', 'audio');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    // Métodos de utilidad
    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFileExtensionAttribute()
    {
        return pathinfo($this->original_name, PATHINFO_EXTENSION);
    }

    public function isImage()
    {
        return $this->file_type === 'image';
    }

    public function isDocument()
    {
        return $this->file_type === 'document';
    }

    public function isVideo()
    {
        return $this->file_type === 'video';
    }

    public function isAudio()
    {
        return $this->file_type === 'audio';
    }

    public function getThumbnailUrl()
    {
        if ($this->isImage()) {
            // Para imágenes, podríamos generar thumbnails
            return $this->file_url;
        }
        
        // Para otros tipos de archivo, mostrar iconos
        return $this->getFileTypeIcon();
    }

    public function getFileTypeIcon()
    {
        $icons = [
            'image' => '🖼️',
            'document' => '📄',
            'video' => '🎥',
            'audio' => '🎵',
            'other' => '📁',
        ];

        return $icons[$this->file_type] ?? '📁';
    }

    // Eliminar archivo físico al eliminar el registro
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($mediaFile) {
            if (Storage::exists($mediaFile->file_path)) {
                Storage::delete($mediaFile->file_path);
            }
        });
    }
}
