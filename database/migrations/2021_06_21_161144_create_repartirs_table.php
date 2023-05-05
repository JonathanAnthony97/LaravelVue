<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepartirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repartirs', function (Blueprint $table) {
            $table->increments('id_rep');
            $table->date('date_rep');
            $table->bigInteger('qte_rep');

            //cle etranger article,cisco
            $table->integer('id_a')->unsigned()->index();
            $table->foreign('id_a')->references('id_a')->on('articles')->onDelete('cascade');

            $table->integer('id_cisco')->unsigned()->index();
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
        Schema::dropIfExists('repartirs');
    }
}
