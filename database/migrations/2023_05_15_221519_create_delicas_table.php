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
        Schema::create('delicas', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->string('size')->default('11');
            $table->string('color')->nullable();
            $table->string('finish')->nullable();
            $table->string('material')->nullable();
            $table->string('shape')->nullable();
            $table->string('image_photo_url')->nullable();
            $table->string('image_color_url')->nullable();
            $table->string('source_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delicas');
    }
};
