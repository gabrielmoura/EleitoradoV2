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
        Schema::create('group_people', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->timestamp('checked_at')->nullable();
            $table->unsignedInteger('checked_by')->nullable();

            $table->foreignId('person_id')->constrained('people');
            $table->foreignId('group_id')->constrained('groups');
            $table->index(['person_id', 'group_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_people');
    }
};
