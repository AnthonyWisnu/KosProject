<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Helper function to check if index exists
        $indexExists = function ($table, $indexName) {
            $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
            return !empty($indexes);
        };

        // Add indexes to rooms table (skip existing: status, room_type)
        Schema::table('rooms', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('rooms', 'rooms_price_index')) {
                $table->index('price');
            }
            // Skip composite index to avoid conflict with existing indexes
        });

        // Add indexes to tenants table
        Schema::table('tenants', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('tenants', 'tenants_room_id_index')) {
                $table->index('room_id');
            }
            if (!$indexExists('tenants', 'tenants_user_id_index')) {
                $table->index('user_id');
            }
        });

        // Add indexes to payments table
        Schema::table('payments', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('payments', 'payments_tenant_id_index')) {
                $table->index('tenant_id');
            }
            if (!$indexExists('payments', 'payments_due_date_index')) {
                $table->index('due_date');
            }
        });

        // Add indexes to bookings table
        Schema::table('bookings', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('bookings', 'bookings_room_id_index')) {
                $table->index('room_id');
            }
            if (!$indexExists('bookings', 'bookings_check_out_date_index')) {
                $table->index('check_out_date');
            }
        });

        // Add indexes to complaints table
        Schema::table('complaints', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('complaints', 'complaints_tenant_id_index')) {
                $table->index('tenant_id');
            }
            if (!$indexExists('complaints', 'complaints_room_id_index')) {
                $table->index('room_id');
            }
            if (!$indexExists('complaints', 'complaints_priority_index')) {
                $table->index('priority');
            }
        });

        // Add indexes to ratings table
        Schema::table('ratings', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('ratings', 'ratings_room_id_index')) {
                $table->index('room_id');
            }
            if (!$indexExists('ratings', 'ratings_user_id_index')) {
                $table->index('user_id');
            }
        });

        // Add indexes to room_images table
        Schema::table('room_images', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('room_images', 'room_images_room_id_index')) {
                $table->index('room_id');
            }
        });

        // Add indexes to room_facility table (pivot)
        if (Schema::hasTable('room_facility')) {
            Schema::table('room_facility', function (Blueprint $table) use ($indexExists) {
                if (!$indexExists('room_facility', 'room_facility_room_id_index')) {
                    $table->index('room_id');
                }
                if (!$indexExists('room_facility', 'room_facility_facility_id_index')) {
                    $table->index('facility_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Helper function to check if index exists
        $indexExists = function ($table, $indexName) {
            $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
            return !empty($indexes);
        };

        // Drop indexes from rooms table
        Schema::table('rooms', function (Blueprint $table) use ($indexExists) {
            if ($indexExists('rooms', 'rooms_price_index')) {
                $table->dropIndex(['price']);
            }
        });

        // Drop indexes from tenants table
        Schema::table('tenants', function (Blueprint $table) use ($indexExists) {
            if ($indexExists('tenants', 'tenants_room_id_index')) {
                $table->dropIndex(['room_id']);
            }
            if ($indexExists('tenants', 'tenants_user_id_index')) {
                $table->dropIndex(['user_id']);
            }
        });

        // Drop indexes from payments table
        Schema::table('payments', function (Blueprint $table) use ($indexExists) {
            if ($indexExists('payments', 'payments_tenant_id_index')) {
                $table->dropIndex(['tenant_id']);
            }
            if ($indexExists('payments', 'payments_due_date_index')) {
                $table->dropIndex(['due_date']);
            }
        });

        // Drop indexes from bookings table
        Schema::table('bookings', function (Blueprint $table) use ($indexExists) {
            if ($indexExists('bookings', 'bookings_room_id_index')) {
                $table->dropIndex(['room_id']);
            }
            if ($indexExists('bookings', 'bookings_check_out_date_index')) {
                $table->dropIndex(['check_out_date']);
            }
        });

        // Drop indexes from complaints table
        Schema::table('complaints', function (Blueprint $table) use ($indexExists) {
            if ($indexExists('complaints', 'complaints_tenant_id_index')) {
                $table->dropIndex(['tenant_id']);
            }
            if ($indexExists('complaints', 'complaints_room_id_index')) {
                $table->dropIndex(['room_id']);
            }
            if ($indexExists('complaints', 'complaints_priority_index')) {
                $table->dropIndex(['priority']);
            }
        });

        // Drop indexes from ratings table
        Schema::table('ratings', function (Blueprint $table) use ($indexExists) {
            if ($indexExists('ratings', 'ratings_room_id_index')) {
                $table->dropIndex(['room_id']);
            }
            if ($indexExists('ratings', 'ratings_user_id_index')) {
                $table->dropIndex(['user_id']);
            }
        });

        // Drop indexes from room_images table
        Schema::table('room_images', function (Blueprint $table) use ($indexExists) {
            if ($indexExists('room_images', 'room_images_room_id_index')) {
                $table->dropIndex(['room_id']);
            }
        });

        // Drop indexes from room_facility table
        if (Schema::hasTable('room_facility')) {
            Schema::table('room_facility', function (Blueprint $table) use ($indexExists) {
                if ($indexExists('room_facility', 'room_facility_room_id_index')) {
                    $table->dropIndex(['room_id']);
                }
                if ($indexExists('room_facility', 'room_facility_facility_id_index')) {
                    $table->dropIndex(['facility_id']);
                }
            });
        }
    }
};
