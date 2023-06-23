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
        Schema::create('datapeminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminjam_id');
            $table->unsignedBigInteger('jenis_barang_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('quantity');
            $table->date('tanggal_pinjam');
            $table->enum('status', ['Sedang Dipinjam', 'Sudah Dikembalikan'])->default('Sedang Dipinjam');
            $table->foreign('jenis_barang_id')->references('id')->on('jenisbarang')->restrictOnDelete();
            $table->foreign('barang_id')->references('id')->on('databarang')->restrictOnDelete();
            $table->foreign('peminjam_id')->references('id')->on('users')->restrictOnDelete();
            $table->string('ktp_peminjam')->nullable();
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
        Schema::dropIfExists('Peminjaman');
    }
};
