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
        Schema::create('databarang', function (Blueprint $table) {
            $table->id();
            $table->string('admin_id');
            $table->string('nama_barang');
            $table->unsignedBigInteger('jenis_barang_id')->nullable();
            $table->string('harga_barang');
            $table->string('quantity');
            $table->string('tersedia');
            $table->foreign('jenis_barang_id')->references('id')->on('jenisbarang')->restrictOnDelete();
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
        Schema::dropIfExists('databarang');
    }
};