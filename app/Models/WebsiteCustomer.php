<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebsiteCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'admin_negocios_user_id',
        'email',
        'name',
        'phone',
        'first_login_at',
        'last_login_at',
        'first_purchase_at',
        'last_purchase_at',
        'total_orders',
        'total_spent',
    ];

    protected function casts(): array
    {
        return [
            'first_login_at' => 'datetime',
            'last_login_at' => 'datetime',
            'first_purchase_at' => 'datetime',
            'last_purchase_at' => 'datetime',
            'total_spent' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relaciones
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    // Métodos útiles
    public function recordLogin()
    {
        if (!$this->first_login_at) {
            $this->first_login_at = now();
        }
        $this->last_login_at = now();
        $this->save();
    }

    public function recordPurchase($amount)
    {
        if (!$this->first_purchase_at) {
            $this->first_purchase_at = now();
        }
        $this->last_purchase_at = now();
        $this->total_orders++;
        $this->total_spent += $amount;
        $this->save();
    }

    // Scopes
    public function scopeByWebsite($query, $websiteId)
    {
        return $query->where('website_id', $websiteId);
    }

    public function scopeByAdminNegociosUserId($query, $userId)
    {
        return $query->where('admin_negocios_user_id', $userId);
    }

    public function scopeHasPurchased($query)
    {
        return $query->whereNotNull('first_purchase_at');
    }

    public function scopeRecentLogins($query, $days = 30)
    {
        return $query->where('last_login_at', '>=', now()->subDays($days));
    }
}

