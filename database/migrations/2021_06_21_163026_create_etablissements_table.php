<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtablissementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etablissements', function (Blueprint $table) {
            $table->increments('id_etab');
            $table->string('code_etab');
            $table->string('nom_etab');
            $table->string('niveau');
            $table->integer('eff_ens');
            $table->integer('id_zap')->unsigned()->index();
            $table->foreign('id_zap')->references('id_zap')->on('zaps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etablissements');
    }
}
