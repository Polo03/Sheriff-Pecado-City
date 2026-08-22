<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE mensajes MODIFY receptor_id INT UNSIGNED NULL');
    }

    public function down(): void
    {
        DB::statement('DELETE FROM mensajes WHERE receptor_id IS NULL');
        DB::statement('ALTER TABLE mensajes MODIFY receptor_id INT UNSIGNED NOT NULL');
    }
};
