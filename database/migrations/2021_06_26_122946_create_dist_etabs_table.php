<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistEtabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dist_etabs', function (Blueprint $table) {
            $table->id();

            $table->integer('id_etab')->unsigned()->index();
            $table->foreign('id_etab')->references('id_etab')->on('etablissements')->onDelete('cascade');

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
        Schema::dropIfExists('dist_etabs');
    }
}
