<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mensajes', function (Blueprint $table) {
            $table->string('canal', 30)->nullable()->after('receptor_id');
            $table->index(['canal', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('mensajes', function (Blueprint $table) {
            $table->dropIndex(['canal', 'created_at']);
            $table->dropColumn('canal');
        });
    }
};
