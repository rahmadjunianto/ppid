<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToPegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('nama');
            $table->string('email')->nullable()->after('foto');
            $table->string('telepon')->nullable()->after('email');
            $table->text('alamat')->nullable()->after('telepon');
            $table->enum('status', ['aktif', 'non_aktif'])->default('aktif')->after('alamat');
        });
    }

    public function down()
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropColumn(['nip', 'email', 'telepon', 'alamat', 'status']);
        });
    }
}
