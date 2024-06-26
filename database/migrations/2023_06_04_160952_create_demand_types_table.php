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
        Schema::create('demand_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->uuid('pid')->index()->comment('Public id');
            $table->uuid('tenant_id')->index()->comment('Tenant id');
            $table->string('name', 100);
            $table->string('description', 255)->nullable();
            $table->string('responsible', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demand_types');
    }
};
