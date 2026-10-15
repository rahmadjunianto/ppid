<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sops', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen');
            $table->enum('grup', ['SOP PPID', 'SOP Bidang Lain'])->default('SOP PPID');
            $table->string('nomor')->nullable();
            $table->year('tahun')->nullable();
            $table->string('file')->nullable();
            $table->string('ukuran')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamps();

            $table->index(['grup', 'status']);
            $table->index('tahun');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sops');
    }
}
