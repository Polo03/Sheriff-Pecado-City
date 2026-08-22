<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fichas_agentes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('agente_id');
            $table->unsignedInteger('creada_por');
            $table->string('placa', 45);
            $table->timestamps();

            $table->index(['agente_id', 'created_at']);
            $table->index('creada_por');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fichas_agentes');
    }
};
