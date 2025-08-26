<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            
            // Biodata Responden
            $table->string('nama');
            $table->integer('umur');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('no_hp');
            $table->string('pendidikan');
            $table->string('pekerjaan');
            
            // Jawaban Survey (1-4 scale)
            $table->tinyInteger('kemudahan_akses_informasi'); // 1-4
            $table->tinyInteger('kualitas_informasi'); // 1-4
            $table->tinyInteger('kemudahan_permintaan'); // 1-4
            $table->tinyInteger('ketepatan_waktu_jawab'); // 1-4
            $table->tinyInteger('kelengkapan_informasi'); // 1-4
            $table->tinyInteger('ketepatan_tanggap'); // 1-4
            $table->tinyInteger('pelayanan_petugas'); // 1-4
            
            // Saran dan Masukan
            $table->text('saran_masukan')->nullable();
            
            // Meta Data
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
