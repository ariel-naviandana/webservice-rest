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
        Schema::create('film_cast', function (Blueprint $table) {
            $table->foreignId('film_id')->constrained()->onDelete('cascade');
            $table->foreignId('cast_id')->constrained()->onDelete('cascade');
            $table->string('character')->nullable();
            $table->primary(['film_id', 'cast_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_cast');
    }
};
