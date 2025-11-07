<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'room_number',
        'room_type',
        'capacity',
        'price',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    /**
     * Relasi ke RoomImage
     */
    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }

    /**
     * Get primary image
     */
    public function primaryImage()
    {
        return $this->hasOne(RoomImage::class)->where('is_primary', true);
    }

    /**
     * Relasi Many-to-Many ke Facility
     */
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'room_facilities');
    }

    /**
     * Relasi ke Booking
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
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
     * Relasi ke Rating
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Relasi ke PriceHistory
     */
    public function priceHistories()
    {
        return $this->hasMany(PriceHistory::class);
    }

    /**
     * Get active tenant
     */
    public function activeTenant()
    {
        return $this->hasOne(Tenant::class)->where('status', 'active');
    }

    /**
     * Get average rating
     */
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    /**
     * Scope untuk status tersedia
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'tersedia');
    }

    /**
     * Scope untuk tipe kamar
     */
    public function scopeByType($query, $type)
    {
        return $query->where('room_type', $type);
    }
}
