<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'blog_post_id',
        'quantity',
        'price',
        'total',
        'admin_negocios_product_id',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price' => 'decimal:2',
            'total' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relaciones
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }

    // Métodos
    public function calculateTotal()
    {
        $this->total = $this->quantity * $this->price;
        $this->save();
    }

    // Scopes
    public function scopeByCart($query, $cartId)
    {
        return $query->where('cart_id', $cartId);
    }
}
