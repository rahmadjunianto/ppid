<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pustaka_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grup_dokumen_id')->constrained('grup_dokumens')->onDelete('cascade');
            $table->string('nama_dokumen');
            $table->string('nomor')->nullable();
            $table->year('tahun')->nullable();
            $table->enum('link_type', ['file', 'link'])->default('file');
            $table->string('file')->nullable();
            $table->string('link_url')->nullable();
            $table->string('ukuran')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pustaka_dokumens');
    }
};
