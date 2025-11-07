# Performance Optimization Guide

This document outlines the performance optimizations implemented in the Kost Management Application.

## Database Optimizations

### Indexes
Added database indexes to improve query performance on frequently accessed columns:

**Rooms Table:**
- `status` - For filtering available rooms
- `room_type` - For filtering by room type
- `price` - For sorting by price
- Composite: `(status, room_type)` - For combined filters

**Tenants Table:**
- `room_id` - Foreign key lookup
- `user_id` - Foreign key lookup
- `status` - For filtering active tenants
- Composite: `(status, check_out_date)` - For active tenant queries

**Payments Table:**
- `tenant_id` - Foreign key lookup
- `payment_status` - For filtering by status
- `payment_date` - For date range queries
- `due_date` - For finding overdue payments
- Composite: `(payment_status, due_date)` - For overdue queries

**Bookings Table:**
- `room_id` - Foreign key lookup
- `status` - For filtering by status
- `check_in_date` - For date queries
- `check_out_date` - For date queries
- Composite: `(status, check_in_date)` - For pending bookings

**Complaints Table:**
- `tenant_id` - Foreign key lookup
- `room_id` - Foreign key lookup
- `status` - For filtering by status
- `priority` - For filtering by priority
- Composite: `(status, priority)` - For urgent complaints

**Ratings Table:**
- `room_id` - Foreign key lookup
- `user_id` - Foreign key lookup
- `rating` - For filtering by rating
- Composite: `(room_id, user_id)` - For duplicate checks

### Running Migrations
```bash
php artisan migrate
```

## Caching Implementation

### CacheService
Implemented a centralized caching service (`app/Services/CacheService.php`) that provides:

- **Available Rooms Cache** - Caches list of available rooms with images and facilities
- **Room Statistics** - Caches room counts by status
- **Payment Statistics** - Caches payment data and monthly totals
- **Rating Statistics** - Caches average ratings and distribution
- **Tenant Statistics** - Caches tenant counts
- **Booking Statistics** - Caches booking status counts

### Cache Duration
Default cache duration: **1 hour (3600 seconds)**

Configure via `.env`:
```env
CACHE_ENABLED=true
CACHE_DURATION=3600
CACHE_PREFIX=kost_
```

### Cache Invalidation
Automatic cache clearing via Model Observers:

- **RoomObserver** - Clears room cache when rooms are created/updated/deleted
- **PaymentObserver** - Clears payment cache when payments are modified
- **RatingObserver** - Clears rating cache when ratings are modified

### Manual Cache Clearing
```php
use App\Services\CacheService;

// Clear all cache
CacheService::clearAll();

// Clear specific cache
CacheService::clearRoomCache();
CacheService::clearPaymentCache();
CacheService::clearRatingCache();
CacheService::clearTenantCache();
CacheService::clearBookingCache();
```

## Query Optimization

### Eager Loading
All controllers use eager loading to prevent N+1 query problems:

```php
// Example: Loading rooms with relationships
Room::with(['images', 'facilities'])->get();

// Example: Loading ratings with user and room
Rating::with(['user', 'room'])->get();
```

### Pagination
All list views use pagination to limit query results:
- Admin views: 15 items per page
- Tenant views: 10 items per page
- Public views: 12 items per page

## Image Optimization

### Configuration
Images can be optimized with the following settings in `config/optimization.php`:

```php
'images' => [
    'max_upload_size' => 5120, // KB
    'thumbnails' => [
        'enabled' => true,
        'width' => 300,
        'height' => 300,
    ],
    'compression' => [
        'enabled' => true,
        'quality' => 85,
    ],
],
```

### Recommendations
- Store images in `storage/app/public/room_images`
- Use thumbnails for list views
- Implement lazy loading for images on public pages
- Consider using CDN for production

## Performance Monitoring

### Query Logging
Enable slow query logging in `.env`:

```env
LOG_SLOW_QUERIES=true
SLOW_QUERY_THRESHOLD=1000
```

This will log queries that take longer than 1000ms.

### Laravel Debugbar (Development)
For development, install Laravel Debugbar:

```bash
composer require barryvdh/laravel-debugbar --dev
```

### Production Monitoring
Consider implementing:
- **Laravel Telescope** - For debugging and monitoring
- **New Relic** or **Blackfire** - For application performance monitoring
- **Laravel Horizon** - For queue monitoring (if using queues)

## Best Practices

### Database
- ✅ Use indexes on frequently queried columns
- ✅ Use eager loading to prevent N+1 queries
- ✅ Implement pagination for large datasets
- ✅ Use database transactions for critical operations

### Caching
- ✅ Cache expensive queries and computations
- ✅ Automatically invalidate cache when data changes
- ✅ Use appropriate cache duration based on data volatility
- ✅ Consider using Redis for production caching

### Code
- ✅ Use Service classes for business logic
- ✅ Use Observers for automatic actions
- ✅ Keep controllers thin
- ✅ Use queues for long-running tasks

### Frontend
- ✅ Minimize HTTP requests
- ✅ Use CDN for static assets in production
- ✅ Implement lazy loading for images
- ✅ Minimize and compress CSS/JS

## Deployment Optimizations

Before deploying to production:

```bash
# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize for production
php artisan optimize
```

## Testing Performance

### Database Query Analysis
```bash
# Enable query logging in config/database.php
'mysql' => [
    ...
    'options' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode="STRICT_TRANS_TABLES"'
    ],
],
```

### Load Testing
Consider using tools like:
- **Apache Bench (ab)**
- **JMeter**
- **Laravel Dusk** for browser testing

## Monitoring Checklist

- [ ] Database query performance
- [ ] Cache hit rates
- [ ] Page load times
- [ ] Memory usage
- [ ] CPU usage
- [ ] Disk I/O
- [ ] API response times

## Additional Recommendations

1. **Use Queue Workers** for:
   - Email notifications
   - Image processing
   - Report generation
   - Bulk operations

2. **Implement Rate Limiting** for:
   - API endpoints
   - Public booking forms
   - Login attempts

3. **Use Asset Compilation** in production:
   ```bash
   npm run build
   ```

4. **Enable OPcache** in PHP configuration for production

5. **Use HTTP/2** with modern web servers

6. **Implement Content Security Policy (CSP)** headers

---

Last Updated: Phase 9 - Testing & Optimization
