<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'blog_post_id',
        'parent_id',
        'author_name',
        'author_email',
        'author_website',
        'content',
        'ip_address',
        'user_agent',
        'is_approved',
        'is_spam',
        'likes_count',
        'dislikes_count',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'is_spam' => 'boolean',
            'likes_count' => 'integer',
            'dislikes_count' => 'integer',
        ];
    }

    // Relaciones
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function scopeSpam($query)
    {
        return $query->where('is_spam', true);
    }

    public function scopeNotSpam($query)
    {
        return $query->where('is_spam', false);
    }

    public function scopeForBlogPost($query, $blogPostId)
    {
        return $query->where('blog_post_id', $blogPostId);
    }

    // Métodos de utilidad
    public function approve()
    {
        $this->update(['is_approved' => true]);
    }

    public function unapprove()
    {
        $this->update(['is_approved' => false]);
    }

    public function markAsSpam()
    {
        $this->update(['is_spam' => true]);
    }

    public function markAsNotSpam()
    {
        $this->update(['is_spam' => false]);
    }

    public function isReply()
    {
        return !is_null($this->parent_id);
    }

    public function getStatusAttribute()
    {
        if ($this->is_spam) {
            return 'spam';
        }
        
        return $this->is_approved ? 'approved' : 'pending';
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'approved' => 'Aprobado',
            'pending' => 'Pendiente',
            'spam' => 'Spam',
            default => 'Desconocido'
        };
    }
}
