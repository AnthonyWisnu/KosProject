<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
    ];

    /**
     * Relasi Many-to-Many ke Room
     */
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_facilities');
    }
}
