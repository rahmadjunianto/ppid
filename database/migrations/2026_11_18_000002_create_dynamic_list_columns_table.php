<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dynamic_list_columns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dynamic_list_id')->constrained('dynamic_lists')->onDelete('cascade');
            $table->string('key', 100);
            $table->string('label');
            $table->string('type', 20)->default('text')
                ->comment('text, textarea, number, date, select, boolean, file, action');
            $table->json('options')->nullable()->comment('Pilihan untuk kolom select');
            $table->string('action_type', 20)->nullable()
                ->comment('internal, external, file - wajib bila type = action');
            $table->boolean('is_multiple')->default(false)->comment('Sel boleh berisi banyak nilai');
            $table->boolean('is_required')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['dynamic_list_id', 'key']);
            $table->index(['dynamic_list_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dynamic_list_columns');
    }
};
