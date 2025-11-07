<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCache extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month',
        'total_income',
        'total_bookings',
        'occupancy_rate',
        'report_data',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'month' => 'integer',
            'total_income' => 'decimal:2',
            'total_bookings' => 'integer',
            'occupancy_rate' => 'decimal:2',
            'report_data' => 'array',
        ];
    }

    /**
     * Get report for specific month/year
     */
    public static function getReport($year, $month)
    {
        return static::where('year', $year)
                     ->where('month', $month)
                     ->first();
    }
}
