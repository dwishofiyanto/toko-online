<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan')->nullable();;
            $table->string('email')->nullable();;
            $table->string('password')->nullable();;
            $table->string('no_hp')->nullable();;
            $table->string('provinsi')->nullable();;
            $table->string('kabupaten')->nullable();;
            $table->string('kecamatan')->nullable();;
            $table->text('alamat_lengkap')->nullable();;
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
        Schema::dropIfExists('pelanggans');
    }
};
