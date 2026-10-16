<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasi_berkala', function (Blueprint $table) {
            $table->id();
            $table->string('kategori', 1)->comment('A, B, C, D, E');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('link')->nullable()->comment('Internal slug or external URL');
            $table->string('link_type', 10)->default('internal')->comment('internal, external, file');
            $table->string('file')->nullable();
            $table->bigInteger('ukuran')->nullable();
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->integer('sort_order')->default(0);
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            $table->index(['kategori', 'status', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_berkala');
    }
};