<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'plan_id',
        'is_active',
        'auth_eme10_id',
        'auth_eme10_token',
        'avatar',
        'two_factor_enabled',
        'two_factor_method',
        'auth_eme10_session_id',
        'last_auth_sync',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'auth_eme10_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'two_factor_enabled' => 'boolean',
            'last_auth_sync' => 'datetime',
        ];
    }

    // Relaciones
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function websites()
    {
        return $this->hasMany(Website::class);
    }

    // Métodos de utilidad
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCreator()
    {
        return $this->role === 'creator';
    }

    /**
     * Verificar si el usuario está sincronizado con Auth EME10
     */
    public function isSyncedWithAuthEME10(): bool
    {
        return !is_null($this->auth_eme10_id) && !is_null($this->auth_eme10_token);
    }

    /**
     * Obtener el token de Auth EME10
     */
    public function getAuthEME10Token(): ?string
    {
        return $this->auth_eme10_token;
    }

    /**
     * Actualizar token de Auth EME10
     */
    public function updateAuthEME10Token(string $token): void
    {
        $this->auth_eme10_token = $token;
        $this->last_auth_sync = now();
        $this->save();
    }

    /**
     * Sincronizar datos desde Auth EME10
     */
    public function syncFromAuthEME10(array $userData): void
    {
        $this->update([
            'name' => $userData['name'] ?? $this->name,
            'email' => $userData['email'] ?? $this->email,
            'phone' => $userData['phone'] ?? $this->phone,
            'avatar' => $userData['avatar'] ?? $this->avatar,
            'is_active' => $userData['is_active'] ?? $this->is_active,
            'two_factor_enabled' => $userData['two_factor_enabled'] ?? $this->two_factor_enabled,
            'auth_eme10_id' => $userData['id'] ?? $this->auth_eme10_id,
            'last_auth_sync' => now(),
        ]);
    }

    /**
     * Verificar si necesita sincronización (más de 5 minutos sin sync)
     */
    public function needsSync(): bool
    {
        if (is_null($this->last_auth_sync)) {
            return true;
        }

        return $this->last_auth_sync->diffInMinutes(now()) > 5;
    }
}
