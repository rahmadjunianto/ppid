<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGolonganToPegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->string('golongan')->nullable()->after('jabatan');
        });
    }

    public function down()
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropColumn('golongan');
        });
    }
}
