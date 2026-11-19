<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dynamic_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dynamic_list_id')->constrained('dynamic_lists')->onDelete('cascade');
            $table->json('data')->nullable()->comment('Nilai setiap kolom, key = kolom.key');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['dynamic_list_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dynamic_list_items');
    }
};
