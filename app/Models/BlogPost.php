<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'meta_data',
        'is_published',
        'published_at',
        'is_product',
        'price',
        'stock',
        'sku',
    ];

    protected function casts(): array
    {
        return [
            'meta_data' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'is_product' => 'boolean',
            'price' => 'decimal:2',
        ];
    }

    // Relaciones
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_post_tags');
    }

    public function forms()
    {
        return $this->hasMany(Form::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByTag($query, $tagId)
    {
        return $query->whereHas('tags', function($q) use ($tagId) {
            $q->where('tag_id', $tagId);
        });
    }

    public function scopeProducts($query)
    {
        return $query->where('is_product', true);
    }
}
