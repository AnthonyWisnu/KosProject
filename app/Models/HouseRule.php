<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    /**
     * Scope untuk order by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
