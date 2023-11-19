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
        Schema::create('demand_group', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('group_id')->nullable()->constrained('groups')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('demand_id')->nullable()->constrained('demands')->nullOnDelete()->cascadeOnUpdate();
            $table->index(['group_id', 'demand_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demand_group');
    }
};
