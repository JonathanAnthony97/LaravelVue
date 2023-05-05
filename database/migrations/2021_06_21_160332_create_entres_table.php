<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entres', function (Blueprint $table) {
            $table->increments('id_e');
            $table->bigInteger('qte_entre');
            $table->date('date_entre');

            //cle etranger article
            $table->integer('id_a')->unsigned()->index();
            $table->foreign('id_a')->references('id_a')->on('articles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entres');
    }
}
