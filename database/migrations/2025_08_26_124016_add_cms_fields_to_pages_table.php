<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCmsFieldsToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            // Add missing CMS fields if they don't exist
            if (!Schema::hasColumn('pages', 'template')) {
                $table->string('template')->default('default')->after('featured_image');
            }
            if (!Schema::hasColumn('pages', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('template');
            }
            if (!Schema::hasColumn('pages', 'show_in_menu')) {
                $table->boolean('show_in_menu')->default(true)->after('sort_order');
            }
            if (!Schema::hasColumn('pages', 'is_homepage')) {
                $table->boolean('is_homepage')->default(false)->after('show_in_menu');
            }
            if (!Schema::hasColumn('pages', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable()->after('meta_description');
            }
            if (!Schema::hasColumn('pages', 'custom_fields')) {
                $table->json('custom_fields')->nullable()->after('is_homepage');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'template',
                'parent_id',
                'show_in_menu',
                'is_homepage',
                'meta_keywords',
                'custom_fields'
            ]);
        });
    }
}
