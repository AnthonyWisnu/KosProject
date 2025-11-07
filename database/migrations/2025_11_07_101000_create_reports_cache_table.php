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
        Schema::create('reports_cache', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('month');
            $table->decimal('total_income', 12, 2)->default(0);
            $table->integer('total_bookings')->default(0);
            $table->decimal('occupancy_rate', 5, 2)->default(0); // percentage
            $table->json('report_data')->nullable();
            $table->timestamps();

            $table->unique(['year', 'month']);
            $table->index('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports_cache');
    }
};
