<?php

use App\Service\Enum\PersonOptions;
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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('pid')->comment('Person Public id');
            $table->uuid('tenant_id')->comment('Tenant id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('telephone')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->date('dateOfBirth')->nullable();
            $table->boolean('dateOfBirthIncludeYear')->default(true)->nullable();

            $table->enum('sex', PersonOptions::getSexOptions())->nullable();
            $table->enum('skinColor', PersonOptions::getSkinColorOptions())->nullable()->comment('Cor da pele');
            $table->enum('maritalStatus', PersonOptions::getMaritalStatusOptions())->nullable()->comment('Estado civil');
            $table->enum('educationLevel', PersonOptions::getEducationLevelOptions())->nullable()->comment('Nível de escolaridade');
            $table->enum('occupation', PersonOptions::getOccupationOptions())->nullable()->comment('Ocupação');
            $table->enum('religion', PersonOptions::getReligionOptions())->nullable()->comment('Religião');
            $table->enum('housing', PersonOptions::getHousingOptions())->nullable()->comment('Moradia');
            $table->enum('sexualOrientation', PersonOptions::sexualOrientationOptions())->nullable()->comment('Orientação sexual');
            $table->enum('genderIdentity', PersonOptions::genderIdentityOptions())->nullable()->comment('Identidade de gênero');
            $table->enum('deficiencyType', PersonOptions::getDeficiencyTypeOptions())->nullable()->comment('Tipo de deficiência');

            $table->text('observation')->nullable();
            $table->string('voter_zone')->nullable();
            $table->string('voter_section')->nullable();
            $table->string('voter_registration')->nullable();

            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->foreignId('address_id')->nullable()->constrained('addresses');

            $table->json('meta')->nullable();
            $table->index(['pid', 'tenant_id', 'created_at']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
