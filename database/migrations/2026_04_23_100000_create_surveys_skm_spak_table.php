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
        Schema::create('surveys_skm_spak', function (Blueprint $table) {
            $table->id();

            // Demographic Data
            $table->string('jenis_kelamin')->nullable(); // Laki-laki, Perempuan
            $table->string('usia')->nullable(); // Range: <20, 21-30, 31-40, 41-50, 51-60, >61
            $table->string('pendidikan_terakhir')->nullable(); // 9 options
            $table->string('pekerjaan')->nullable(); // 9 options
            $table->string('kategori_responden')->nullable(); // Internal/Eksternal
            $table->text('unit_kerja')->nullable(); // Text input
            $table->text('jabatan')->nullable(); // Text input
            $table->string('jenis_pelayanan')->nullable(); // 11 options

            // SKM Unsur (Survei Kepuasan Masyarakat)
            // Scale 1-4: 1=Tidak Sesuai, 2=Kurang Sesuai, 3=Sesuai, 4=Sangat Sesuai
            $table->tinyInteger('u1_persyaratan')->nullable(); // Persyaratan pelayanan
            $table->tinyInteger('u2_prosedur')->nullable(); // Informasi prosedur/alur
            $table->tinyInteger('u3_waktu_pelayanan')->nullable(); // Jangka waktu penyelesaian
            $table->tinyInteger('u4_biaya_tarif')->nullable(); // Tarif/biaya
            $table->tinyInteger('u5_hasil_pelayanan')->nullable(); // Hasil pelayanan
            $table->tinyInteger('u6_kompetensi_petugas')->nullable(); // Kompetensi petugas
            $table->tinyInteger('u7_perilaku_petugas')->nullable(); // Perilaku petugas
            $table->tinyInteger('u8_pengaduan')->nullable(); // Layanan pengaduan
            $table->tinyInteger('u9_sarana_prasarana')->nullable(); // Sarana prasarana

            // SPAK (Survei Persepsi Anti Korupsi)
            // Scale 1-4: 1=Ada, 2=Jarang, 3=Sangat Jarang, 4=Tidak Ada
            $table->tinyInteger('i1_tidak_diskriminatif')->nullable(); // Tidak ada diskriminasi
            $table->tinyInteger('i2_tidak_curang')->nullable(); // Tidak ada kecurangan
            $table->tinyInteger('i3_tidak_imbalan')->nullable(); // Tidak ada imbalan
            $table->tinyInteger('i4_tidak_percaloan')->nullable(); // Tidak ada percaloan
            $table->tinyInteger('i5_tidak_pungli')->nullable(); // Tidak ada pungli

            // Feedback & Rating
            $table->longText('kritik_saran')->nullable(); // Open feedback
            $table->tinyInteger('rating_kualitas_layanan')->nullable(); // Scale 1-5: 1=Sangat Tidak Puas, 5=Sangat Puas

            // Metadata
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys_skm_spak');
    }
};
