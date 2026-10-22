<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE sops MODIFY COLUMN grup ENUM('SOP PPID', 'Sub Bag TU', 'Bimas', 'Pais', 'Pendma', 'PD Pontren', 'Penzawa') DEFAULT 'SOP PPID'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE sops MODIFY COLUMN grup ENUM('SOP PPID', 'Sub Bag TU', 'Bimas', 'Pais', 'Pendma', 'PD Pontren') DEFAULT 'SOP PPID'");
    }
};
