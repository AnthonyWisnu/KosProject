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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number', 20)->unique();
            $table->enum('room_type', ['bulanan', 'harian'])->default('bulanan');
            $table->integer('capacity')->default(1);
            $table->decimal('price', 12, 2);
            $table->text('description')->nullable();
            $table->enum('status', ['tersedia', 'terisi', 'maintenance'])->default('tersedia');
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('room_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
