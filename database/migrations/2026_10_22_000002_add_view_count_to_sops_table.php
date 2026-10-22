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
        if (!Schema::hasColumn('sops', 'view_count')) {
            Schema::table('sops', function (Blueprint $table) {
                $table->unsignedBigInteger('view_count')->default(0)->after('ukuran');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sops', 'view_count')) {
            Schema::table('sops', function (Blueprint $table) {
                $table->dropColumn('view_count');
            });
        }
    }
};
