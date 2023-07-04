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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->uuid('tenant_id')->index();
            $table->timestamps();
            $table->string('title', 100);
            $table->string('description', 100);
            $table->text('message');
            $table->string('status', 100);
            $table->string('url', 100);
            $table->string('attachment', 100)
                ->nullable();
            $table->softDeletes();
            $table->foreignUuid('direct_mail_id')
                ->nullable()
                ->constrained('direct_mails')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
