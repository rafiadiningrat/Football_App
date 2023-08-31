<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePertandinganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pertandingan', function (Blueprint $table) {
            $table->id('id_pertandingan');
            $table->unsignedBigInteger('klub_tuan_rumah_id');
            $table->unsignedBigInteger('klub_tamu_id');
            $table->integer('skor_tuan_rumah');
            $table->integer('skor_tamu');
            $table->timestamps();

            $table->unique(['klub_tuan_rumah_id', 'klub_tamu_id']);
            
            $table->foreign('klub_tuan_rumah_id')->references('id_klub')->on('klub');
            $table->foreign('klub_tamu_id')->references('id_klub')->on('klub');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pertandingan');
    }
}
