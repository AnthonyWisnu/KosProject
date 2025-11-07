<?php

namespace App\Observers;

use App\Models\Room;
use App\Services\CacheService;

class RoomObserver
{
    /**
     * Handle the Room "created" event.
     */
    public function created(Room $room): void
    {
        CacheService::clearRoomCache();
    }

    /**
     * Handle the Room "updated" event.
     */
    public function updated(Room $room): void
    {
        CacheService::clearRoomCache();
    }

    /**
     * Handle the Room "deleted" event.
     */
    public function deleted(Room $room): void
    {
        CacheService::clearRoomCache();
    }

    /**
     * Handle the Room "restored" event.
     */
    public function restored(Room $room): void
    {
        CacheService::clearRoomCache();
    }

    /**
     * Handle the Room "force deleted" event.
     */
    public function forceDeleted(Room $room): void
    {
        CacheService::clearRoomCache();
    }
}
