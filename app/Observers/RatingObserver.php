<?php

namespace App\Observers;

use App\Models\Rating;
use App\Services\CacheService;

class RatingObserver
{
    /**
     * Handle the Rating "created" event.
     */
    public function created(Rating $rating): void
    {
        CacheService::clearRatingCache();
    }

    /**
     * Handle the Rating "updated" event.
     */
    public function updated(Rating $rating): void
    {
        CacheService::clearRatingCache();
    }

    /**
     * Handle the Rating "deleted" event.
     */
    public function deleted(Rating $rating): void
    {
        CacheService::clearRatingCache();
    }

    /**
     * Handle the Rating "restored" event.
     */
    public function restored(Rating $rating): void
    {
        CacheService::clearRatingCache();
    }

    /**
     * Handle the Rating "force deleted" event.
     */
    public function forceDeleted(Rating $rating): void
    {
        CacheService::clearRatingCache();
    }
}
