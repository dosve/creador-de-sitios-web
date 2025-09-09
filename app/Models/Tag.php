<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'name',
        'slug',
        'color',
    ];

    // Relaciones
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function blogPosts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tags');
    }
}
