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
        Schema::create('data_rusaks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('quantity_rusak')->nullable();
            $table->enum('status_rusak', ['rusak', 'diperbaiki'])->default('rusak');
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('barang_id')->references('id')->on('databarang')->restrictOnDelete();
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
        Schema::dropIfExists('data_rusaks');
    }
};
