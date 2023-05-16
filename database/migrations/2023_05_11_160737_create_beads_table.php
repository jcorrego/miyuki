<?php

use App\Models\Project;
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
        Schema::create('beads', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class);
            $table->integer('row');
            $table->integer('col');
            $table->string('color')->default('white');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beads');
    }
};
