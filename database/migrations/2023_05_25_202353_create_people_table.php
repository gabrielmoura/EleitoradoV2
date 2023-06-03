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
        //"nome" varchar COLLATE "pg_catalog"."default",
        //  "logradouro" varchar COLLATE "pg_catalog"."default",
        //  "numero" int4,
        //  "complemento" varchar COLLATE "pg_catalog"."default",
        //  "bairro" varchar COLLATE "pg_catalog"."default",
        //  "cidade" varchar COLLATE "pg_catalog"."default",
        //  "uf" varchar COLLATE "pg_catalog"."default",
        //  "cep" varchar COLLATE "pg_catalog"."default",
        //  "data_aniversario" date,
        //  "telefone" varchar COLLATE "pg_catalog"."default",
        //  "celular" varchar COLLATE "pg_catalog"."default",
        //  "cpf" varchar COLLATE "pg_catalog"."default",
        //  "email" varchar COLLATE "pg_catalog"."default",
        //  "anotacoes" text COLLATE "pg_catalog"."default",
        //  "id_empresa" int4,
        //  "created_at" timestamp(6) NOT NULL,
        //  "updated_at" timestamp(6) NOT NULL,
        //  "foto_file_name" varchar COLLATE "pg_catalog"."default",
        //  "foto_content_type" varchar COLLATE "pg_catalog"."default",
        //  "foto_file_size" int4,
        //  "foto_updated_at" timestamp(6),
        //  "facebook" varchar COLLATE "pg_catalog"."default",
        //  "twitter" varchar COLLATE "pg_catalog"."default",
        //  "google_plus" varchar COLLATE "pg_catalog"."default",
        //  "instagram" varchar COLLATE "pg_catalog"."default",
        //  "linkedin" varchar COLLATE "pg_catalog"."default",
        //  "identidade" varchar COLLATE "pg_catalog"."default",
        //  "ativo" int4 DEFAULT 1,
        //  "sexo" char(1) COLLATE "pg_catalog"."default",
        //  "chaveouvinte" int4,
        //  "id_source_clone" int4,
        //  "is_guest" int4 DEFAULT 0,
        //  "zona" varchar COLLATE "pg_catalog"."default",
        //  "secao" varchar COLLATE "pg_catalog"."default",
        //  "titulo" varchar COLLATE "pg_catalog"."default",
        //  "data_notificacao" timestamp(6),
        //  "imprimir_placa" bool,
        //  "profissao" varchar COLLATE "pg_catalog"."default",
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('pid')->comment('Person Public id');
            $table->uuid('tenant_id')->comment('Tenant id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->date('dateOfBirth')->nullable();
            $table->boolean('dateOfBirthIncludeYear')->default(true)->nullable();
            $table->enum('sex',['m','f','o'])->nullable();
            $table->string('voter_zone')->nullable();
            $table->string('voter_section')->nullable();
            $table->string('voter_registration')->nullable();

            $table->foreignId('address_id')->nullable()->constrained('addresses');

            $table->json('meta')->nullable();
            $table->index(['pid', 'tenant_id','created_at']);

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
