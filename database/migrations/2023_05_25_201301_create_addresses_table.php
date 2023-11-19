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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->uuid('tenant_id')->index()->comment('Tenant id');

            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('zipcode', 10)->nullable();
            $table->string('country', 2)->nullable();
            $table->integer('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('reference')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();

            $table->timestamp('processed_at')->nullable()->comment('Data de processamento do endereço');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
