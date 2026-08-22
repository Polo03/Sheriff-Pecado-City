<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anuncios', function (Blueprint $table) {
            $table->string('tipo', 20)->default('anuncios')->after('agente_id');
            $table->index(['tipo', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('anuncios', function (Blueprint $table) {
            $table->dropIndex(['tipo', 'created_at']);
            $table->dropColumn('tipo');
        });
    }
};
