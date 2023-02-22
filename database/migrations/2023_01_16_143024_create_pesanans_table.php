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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pelanggan');
            $table->string('invoice');
            $table->integer('grand_total');
            $table->timestamps();
        });

        Schema::create('pesanan_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pesanan');
            $table->integer('id_produk');
            $table->integer('jumlah');
            $table->string('size');
            $table->string('warna');
            $table->integer('total');
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
        Schema::dropIfExists('pesanans');
    }
};
