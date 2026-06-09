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
        Schema::create('survey_periods', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->enum('quarter', ['tw1', 'tw2', 'tw3', 'tw4', 'annual']);
            $table->enum('survey_type', ['ikm', 'spak', 'both'])->default('both');
            
            // Nilai IKM (skala 25-100)
            $table->decimal('ikm_value', 5, 2)->nullable();
            $table->enum('ikm_category', ['A', 'B', 'C', 'D'])->nullable();
            $table->string('ikm_category_label')->nullable(); // Sangat Baik, Baik, Cukup, Buruk
            
            // Nilai SPAK (skala 25-100)
            $table->decimal('spak_value', 5, 2)->nullable();
            $table->enum('spak_category', ['A', 'B', 'C', 'D'])->nullable();
            $table->string('spak_category_label')->nullable();
            
            // Statistik responden
            $table->integer('total_respondents')->default(0);
            $table->integer('target_respondents')->default(100);
            $table->decimal('response_rate', 5, 2)->nullable();
            
            // Detail per unsur (JSON)
            $table->json('ikm_unsur_details')->nullable(); // Detail 9 unsur SKM
            $table->json('spak_unsur_details')->nullable(); // Detail 5 unsur SPAK
            
            // Periode survei
            $table->date('survey_start_date');
            $table->date('survey_end_date');
            $table->text('notes')->nullable();
            
            // Status publikasi
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            
            // Tanda tangan pimpinan
            $table->string('signatory_name')->nullable();
            $table->string('signatory_position')->nullable();
            $table->string('signatory_nip')->nullable();
            $table->string('approval_document_path')->nullable();
            
            $table->timestamps();
            
            // Index untuk query cepat
            $table->index(['year', 'quarter']);
            $table->index(['survey_type', 'is_published']);
            $table->unique(['year', 'quarter', 'survey_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_periods');
    }
};
