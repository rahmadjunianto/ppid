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
        Schema::create('quarterly_reports', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->tinyInteger('quarter'); // 1, 2, 3, atau 4
            $table->enum('type', ['publication', 'trend', 'follow_up', 'summary']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable(); // pdf, excel, doc
            $table->boolean('is_published')->default(false);
            $table->boolean('is_trend_chart')->default(false); // Untuk menandai apakah ini adalah grafik tren
            $table->timestamps();
            
            // Index untuk query cepat
            $table->index(['year', 'quarter']);
            $table->index(['type', 'is_published']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quarterly_reports');
    }
};
