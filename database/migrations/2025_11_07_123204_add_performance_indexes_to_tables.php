<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes to rooms table
        Schema::table('rooms', function (Blueprint $table) {
            $table->index('status');
            $table->index('room_type');
            $table->index('price');
            $table->index(['status', 'room_type']); // Composite index for filtering
        });

        // Add indexes to tenants table
        Schema::table('tenants', function (Blueprint $table) {
            $table->index('room_id');
            $table->index('user_id');
            $table->index('status');
            $table->index(['status', 'check_out_date']); // For active tenant queries
        });

        // Add indexes to payments table
        Schema::table('payments', function (Blueprint $table) {
            $table->index('tenant_id');
            $table->index('payment_status');
            $table->index('payment_date');
            $table->index('due_date');
            $table->index(['payment_status', 'due_date']); // For overdue queries
        });

        // Add indexes to bookings table
        Schema::table('bookings', function (Blueprint $table) {
            $table->index('room_id');
            $table->index('status');
            $table->index('check_in_date');
            $table->index('check_out_date');
            $table->index(['status', 'check_in_date']); // For pending bookings
        });

        // Add indexes to complaints table
        Schema::table('complaints', function (Blueprint $table) {
            $table->index('tenant_id');
            $table->index('room_id');
            $table->index('status');
            $table->index('priority');
            $table->index(['status', 'priority']); // For filtering urgent complaints
        });

        // Add indexes to ratings table
        Schema::table('ratings', function (Blueprint $table) {
            $table->index('room_id');
            $table->index('user_id');
            $table->index('rating');
            $table->index(['room_id', 'user_id']); // For checking duplicates
        });

        // Add indexes to room_images table
        Schema::table('room_images', function (Blueprint $table) {
            $table->index('room_id');
        });

        // Add indexes to room_facility table (pivot)
        Schema::table('room_facility', function (Blueprint $table) {
            $table->index('room_id');
            $table->index('facility_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes from rooms table
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['room_type']);
            $table->dropIndex(['price']);
            $table->dropIndex(['status', 'room_type']);
        });

        // Drop indexes from tenants table
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropIndex(['room_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['status', 'check_out_date']);
        });

        // Drop indexes from payments table
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['tenant_id']);
            $table->dropIndex(['payment_status']);
            $table->dropIndex(['payment_date']);
            $table->dropIndex(['due_date']);
            $table->dropIndex(['payment_status', 'due_date']);
        });

        // Drop indexes from bookings table
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['room_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['check_in_date']);
            $table->dropIndex(['check_out_date']);
            $table->dropIndex(['status', 'check_in_date']);
        });

        // Drop indexes from complaints table
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropIndex(['tenant_id']);
            $table->dropIndex(['room_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['priority']);
            $table->dropIndex(['status', 'priority']);
        });

        // Drop indexes from ratings table
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropIndex(['room_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['rating']);
            $table->dropIndex(['room_id', 'user_id']);
        });

        // Drop indexes from room_images table
        Schema::table('room_images', function (Blueprint $table) {
            $table->dropIndex(['room_id']);
        });

        // Drop indexes from room_facility table
        Schema::table('room_facility', function (Blueprint $table) {
            $table->dropIndex(['room_id']);
            $table->dropIndex(['facility_id']);
        });
    }
};
