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
        Schema::create('demand_people', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('person_id')->constrained('people');
            $table->foreignId('demand_id')->constrained('demands');
            $table->index(['person_id', 'demand_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demand_people');
    }
};
