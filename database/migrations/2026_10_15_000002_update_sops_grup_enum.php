<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE sops MODIFY COLUMN grup ENUM('SOP PPID', 'Sub Bag TU', 'Bimas', 'Pais', 'Pendma', 'PD Pontren') DEFAULT 'SOP PPID'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE sops MODIFY COLUMN grup ENUM('SOP PPID', 'SOP Bidang Lain') DEFAULT 'SOP PPID'");
    }
};
