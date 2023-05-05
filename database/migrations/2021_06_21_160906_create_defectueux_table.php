<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefectueuxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defectueux', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qte_def');
            //cle etrange article
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
        Schema::dropIfExists('defectueux');
    }
}
