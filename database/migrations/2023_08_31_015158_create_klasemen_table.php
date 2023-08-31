<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlasemenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klasemen', function (Blueprint $table) {
            $table->id('id_klasemen');
            $table->unsignedBigInteger('id_klub');
            $table->integer('main')->default(0);
            $table->integer('menang')->default(0);
            $table->integer('seri')->default(0);
            $table->integer('kalah')->default(0);
            $table->integer('goal_menang')->default(0);
            $table->integer('goal_kalah')->default(0);
            $table->timestamps();

            $table->foreign('id_klub')->references('id_klub')->on('klub');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('klasemen');
    }
}
