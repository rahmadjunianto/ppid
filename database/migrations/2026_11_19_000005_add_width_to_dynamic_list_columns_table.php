<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dynamic_list_columns', function (Blueprint $table) {
            $table->unsignedSmallInteger('width')->nullable()->after('sort_order')
                ->comment('Lebar kolom dalam piksel, null = otomatis');
        });
    }

    public function down(): void
    {
        Schema::table('dynamic_list_columns', function (Blueprint $table) {
            $table->dropColumn('width');
        });
    }
};
