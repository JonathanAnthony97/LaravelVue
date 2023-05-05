<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dist_class', function (Blueprint $table) {
            $table->id();

            // cle classe
            $table->integer('id_cls')->unsigned()->index();
            $table->foreign('id_cls')->references('id_cls')->on('classes')->onDelete('cascade');

            // cle distribution
            $table->integer('id_dist')->unsigned()->index();
            $table->foreign('id_dist')->references('id_dist')->on('distributions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dist_class');
    }
}
