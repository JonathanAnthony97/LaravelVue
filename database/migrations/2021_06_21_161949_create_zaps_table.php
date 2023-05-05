<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zaps', function (Blueprint $table) {
            $table->increments('id_zap');
            $table->string('lieu_zap');
            //cle etranger cisco
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
        Schema::dropIfExists('zaps');
    }
}
