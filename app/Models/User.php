<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        ];
    }

    /**
     * Relasi ke Tenant
     */
    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    /**
     * Relasi ke Complaint
     */
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    /**
     * Relasi ke Payment yang diverifikasi
     */
    public function verifiedPayments()
    {
        return $this->hasMany(Payment::class, 'verified_by');
    }

    /**
     * Relasi ke Rating
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Check if user is pemilik
     */
    public function isPemilik(): bool
    {
        return $this->role === 'pemilik';
    }

    /**
     * Check if user is penyewa
     */
    public function isPenyewa(): bool
    {
        return $this->role === 'penyewa';
    }

    /**
     * Get active tenant
     */
    public function activeTenant()
    {
        return $this->hasOne(Tenant::class)->where('status', 'active');
    }
}
