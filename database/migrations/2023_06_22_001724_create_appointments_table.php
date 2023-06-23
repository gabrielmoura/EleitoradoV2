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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->uuid('pid')->unique()->comment('Public ID');
            $table->uuid('tenant_id')->comment('Tenant id');
            $table->integer('appointment_id')->nullable()->comment('Appointment id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name');
            $table->string('description')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->dateTime('start_time');

            $table->string('recurrence')->nullable();
            $table->foreignId('address_id')->nullable()->constrained('addresses');
            $table->json('properties')->nullable();

            $table->foreignId('event_id')->nullable()->constrained('events');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
