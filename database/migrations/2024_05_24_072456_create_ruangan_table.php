<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuanganTable extends Migration
{
    public function up()
    {
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 10);
            $table->string('kode', 10);
            $table->integer('kapasitas');
            $table->string('tipe_ruangan');
            $table->unsignedBigInteger('jurusan_id');
            $table->boolean('tersedia');
            $table->timestamps();
            $table->foreign('jurusan_id')->references('id')->on('jurusan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ruangan');
    }
}
