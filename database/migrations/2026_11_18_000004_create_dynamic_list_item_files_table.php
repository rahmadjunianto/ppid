<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dynamic_list_item_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dynamic_list_item_id')->constrained('dynamic_list_items')->onDelete('cascade');
            $table->foreignId('dynamic_list_column_id')->nullable()->constrained('dynamic_list_columns')->onDelete('set null');
            $table->string('path');
            $table->string('original_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->timestamps();

            $table->index(['dynamic_list_item_id', 'dynamic_list_column_id'], 'dlif_item_col_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dynamic_list_item_files');
    }
};
