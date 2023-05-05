<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id_cls');
            $table->string('nom_cls');
            $table->integer('eff_el');
            //cle etranger etablissement
            $table->integer('id_etab')->unsigned()->index();
            $table->foreign('id_etab')->references('id_etab')->on('etablissements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
}
