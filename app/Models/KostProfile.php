<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KostProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'whatsapp',
        'email',
        'description',
        'logo',
    ];

    /**
     * Get the kost profile (singleton)
     */
    public static function getProfile()
    {
        return static::first() ?? static::create([
            'name' => 'Kost Management',
            'address' => '-',
            'phone' => '-',
            'email' => 'info@kost.com',
        ]);
    }
}
