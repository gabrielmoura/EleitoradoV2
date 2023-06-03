<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('direct_mails', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->ulid('tenant_id')->index()->comment('Tenant id');
            $table->foreignId('person_id')->constrained('people');

            /** Recebeu */
            $table->json('received')->nullable();
            /** Quer receber */
            $table->json('want_to_receive')->nullable();

            /**  Vota? */
            $table->boolean('vote')->nullable();

            /** Conhece a proposta */
            $table->boolean('know_a_proposal')->nullable();

            /** Indica? Quantos? */
            $table->integer('indicate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direct_mails');
    }
};
