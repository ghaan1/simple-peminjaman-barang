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
        Schema::create('data_perbaikans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_perbaikan')->nullable();
            $table->unsignedBigInteger('rusak_id')->nullable();
            $table->string('bukti_perbaikan')->nullable();
            $table->string('ktp_perbaikan')->nullable();
            $table->foreign('rusak_id')->references('id')->on('data_rusaks')->restrictOnDelete();
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
        Schema::dropIfExists('data_perbaikans');
    }
};
