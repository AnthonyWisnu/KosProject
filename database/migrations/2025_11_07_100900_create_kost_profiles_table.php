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
        Schema::create('kost_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->text('address');
            $table->string('phone', 20);
            $table->string('whatsapp', 20)->nullable();
            $table->string('email', 100);
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kost_profiles');
    }
};
