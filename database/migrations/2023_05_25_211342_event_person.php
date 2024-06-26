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
        Schema::create('event_people', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('person_id')->nullable()->constrained('people')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete()->cascadeOnUpdate();
            $table->index(['person_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_people');
    }
};
