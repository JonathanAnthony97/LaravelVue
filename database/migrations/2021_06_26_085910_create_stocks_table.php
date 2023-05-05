<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id_st');
            $table->bigInteger('qte_st');

            //cle etranger article
            $table->integer('id_a')->unsigned()->index();
            $table->foreign('id_a')->references('id_a')->on('articles')->onDelete('cascade');

            //cle etranger cisco // nullable
            $table->integer('id_cisco')->unsigned()->index()->nullable();
            $table->foreign('id_cisco')->references('id_cisco')->on('ciscos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
