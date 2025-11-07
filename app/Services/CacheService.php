<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Rating;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Cache duration in seconds (1 hour)
     */
    const CACHE_DURATION = 3600;

    /**
     * Get available rooms with caching
     */
    public static function getAvailableRooms()
    {
        return Cache::remember('rooms.available', self::CACHE_DURATION, function () {
            return Room::with(['images', 'facilities'])
                ->where('status', 'tersedia')
                ->orderBy('room_number')
                ->get();
        });
    }

    /**
     * Get room statistics with caching
     */
    public static function getRoomStatistics()
    {
        return Cache::remember('rooms.statistics', self::CACHE_DURATION, function () {
            return [
                'total' => Room::count(),
                'available' => Room::where('status', 'tersedia')->count(),
                'occupied' => Room::where('status', 'terisi')->count(),
                'maintenance' => Room::where('status', 'maintenance')->count(),
            ];
        });
    }

    /**
     * Get payment statistics with caching
     */
    public static function getPaymentStatistics()
    {
        return Cache::remember('payments.statistics', self::CACHE_DURATION, function () {
            $currentMonth = now()->month;
            $currentYear = now()->year;

            return [
                'total_monthly' => Payment::whereYear('payment_date', $currentYear)
                    ->whereMonth('payment_date', $currentMonth)
                    ->where('payment_status', 'lunas')
                    ->sum('amount'),
                'pending' => Payment::where('payment_status', 'menunggu')->count(),
                'overdue' => Payment::where('payment_status', 'terlambat')->count(),
                'paid' => Payment::where('payment_status', 'lunas')->count(),
            ];
        });
    }

    /**
     * Get rating statistics with caching
     */
    public static function getRatingStatistics()
    {
        return Cache::remember('ratings.statistics', self::CACHE_DURATION, function () {
            return [
                'average' => Rating::avg('rating') ?? 0,
                'total' => Rating::count(),
                'five_star' => Rating::where('rating', 5)->count(),
                'four_star' => Rating::where('rating', 4)->count(),
                'three_star' => Rating::where('rating', 3)->count(),
                'two_star' => Rating::where('rating', 2)->count(),
                'one_star' => Rating::where('rating', 1)->count(),
            ];
        });
    }

    /**
     * Get tenant statistics with caching
     */
    public static function getTenantStatistics()
    {
        return Cache::remember('tenants.statistics', self::CACHE_DURATION, function () {
            return [
                'total' => Tenant::count(),
                'active' => Tenant::where('status', 'aktif')->count(),
                'inactive' => Tenant::where('status', 'tidak_aktif')->count(),
            ];
        });
    }

    /**
     * Get booking statistics with caching
     */
    public static function getBookingStatistics()
    {
        return Cache::remember('bookings.statistics', self::CACHE_DURATION, function () {
            return [
                'total' => Booking::count(),
                'pending' => Booking::where('status', 'pending')->count(),
                'confirmed' => Booking::where('status', 'confirmed')->count(),
                'cancelled' => Booking::where('status', 'cancelled')->count(),
            ];
        });
    }

    /**
     * Clear all cache
     */
    public static function clearAll()
    {
        Cache::forget('rooms.available');
        Cache::forget('rooms.statistics');
        Cache::forget('payments.statistics');
        Cache::forget('ratings.statistics');
        Cache::forget('tenants.statistics');
        Cache::forget('bookings.statistics');
    }

    /**
     * Clear room-related cache
     */
    public static function clearRoomCache()
    {
        Cache::forget('rooms.available');
        Cache::forget('rooms.statistics');
    }

    /**
     * Clear payment-related cache
     */
    public static function clearPaymentCache()
    {
        Cache::forget('payments.statistics');
    }

    /**
     * Clear rating-related cache
     */
    public static function clearRatingCache()
    {
        Cache::forget('ratings.statistics');
    }

    /**
     * Clear tenant-related cache
     */
    public static function clearTenantCache()
    {
        Cache::forget('tenants.statistics');
    }

    /**
     * Clear booking-related cache
     */
    public static function clearBookingCache()
    {
        Cache::forget('bookings.statistics');
    }
}
