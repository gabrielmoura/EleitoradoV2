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
        Schema::create('permission_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('meta')->nullable();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->foreignId('permission_id')->nullable()
                ->constrained('permissions')->onDelete('set null');

            $table->foreignId('role_id')->nullable()
                ->constrained('roles')->onDelete('set null');

            $table->index(['user_id', 'permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_user');
    }
};
