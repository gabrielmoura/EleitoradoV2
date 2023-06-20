<?php

use App\Service\Enum\DemandOptions;
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
        Schema::create('demands', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->uuid('tenant_id')->index()->comment('Tenant id');
            $table->uuid('pid')->index()->comment('Public id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('solution_date')->nullable()->comment('Data para Solução');
            $table->timestamp('closed_at')->nullable()->comment('Data da Solução');
            $table->enum('status', DemandOptions::STATUS)->default(DemandOptions::STATUS_OPEN)->comment('Demand status');
            $table->enum('priority', DemandOptions::PRIORITY)->default(DemandOptions::PRIORITY_LOW)->comment('Demand priority');

            $table->boolean('active')->default(true)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demands');
    }
};
