<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regulasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_regulasi');
            $table->string('nomor')->nullable();
            $table->enum('tingkat', ['pusat', 'kankemenag'])->default('pusat');
            $table->year('tahun')->nullable();
            $table->enum('link_type', ['file', 'link'])->default('file');
            $table->string('file')->nullable();
            $table->string('link_url')->nullable();
            $table->string('ukuran')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->integer('sort_order')->default(0);
            $table->integer('view_count')->default(0);
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamps();

            $table->index(['tingkat', 'status']);
            $table->index('sort_order');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regulasi');
    }
};
