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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->tinyInteger('interval_count')->default(1);
            $table->string('billing_method')->nullable();
            $table->enum('billing_period', ['day', 'week', 'month', 'year'])->default('month');
            $table->integer('price')->comment('in cents');
            $table->decimal('price_decimal')->nullable();
            $table->string('currency');
            $table->string('description');
            $table->json('metadata')->nullable();
            $table->json('features')->comment('Funcionalidades')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
