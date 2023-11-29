<?php

use App\Service\Enum\CampaignOptions;
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
            $table->uuid('pid')->comment('Person Public id');
            $table->timestamps();
            $table->string('title', 100);
            $table->string('description', 100)->nullable();
            $table->longText('message');
            $table->enum('status', array_values(CampaignOptions::STATUS))->default(CampaignOptions::STATUS_PENDING);
            $table->string('url', 100)->nullable();

            /** Indereçavel a */
            $table->nullableNumericMorphs('to');

            /** Canal */
            $table->enum('channel', array_values(CampaignOptions::CHANNELS))->default(CampaignOptions::CHANNEL_EMAIL);

            /** Meta */
            $table->json('meta')->nullable();

            /** Batch */
            $table->uuid('batch_id')->nullable();

            $table->softDeletes();
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
