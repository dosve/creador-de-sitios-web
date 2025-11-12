<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'admin_negocios_id',
        'is_authenticated',
    ];

    protected function casts(): array
    {
        return [
            'is_authenticated' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relaciones
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function websiteCustomer()
    {
        return $this->belongsTo(WebsiteCustomer::class, 'admin_negocios_id', 'admin_negocios_user_id')
            ->where('website_id', $this->website_id);
    }

    // Scopes
    public function scopeByWebsite($query, $websiteId)
    {
        return $query->where('website_id', $websiteId);
    }
}
