<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('emisor_id');
            $table->unsignedInteger('receptor_id')->nullable();
            $table->text('mensaje');
            $table->timestamp('leido_at')->nullable();
            $table->timestamps();

            $table->index(['emisor_id', 'receptor_id', 'created_at']);
            $table->index(['receptor_id', 'emisor_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};
