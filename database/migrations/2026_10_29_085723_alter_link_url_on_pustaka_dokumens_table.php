<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pustaka_dokumens', function (Blueprint $table) {
            $table->text('link_url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pustaka_dokumens', function (Blueprint $table) {
            $table->string('link_url', 255)->nullable()->change();
        });
    }
};
