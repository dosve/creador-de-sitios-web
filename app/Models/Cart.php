<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'customer_id',
        'session_id',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'total',
        'currency',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'shipping_amount' => 'decimal:2',
            'total' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relaciones
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Métodos
    public function calculateTotals()
    {
        $subtotal = $this->items->sum('total');
        $this->subtotal = $subtotal;
        $this->total = $subtotal + $this->tax_amount + $this->shipping_amount;
        $this->save();
    }

    public function isEmpty()
    {
        return $this->items->count() === 0;
    }

    // Scopes
    public function scopeByWebsite($query, $websiteId)
    {
        return $query->where('website_id', $websiteId);
    }

    public function scopeBySession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }
}
