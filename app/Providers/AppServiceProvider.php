<?php

namespace App\Providers;

use App\Models\Payment;
use App\Models\Rating;
use App\Models\Room;
use App\Observers\PaymentObserver;
use App\Observers\RatingObserver;
use App\Observers\RoomObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers for cache management
        Room::observe(RoomObserver::class);
        Payment::observe(PaymentObserver::class);
        Rating::observe(RatingObserver::class);
    }
}
