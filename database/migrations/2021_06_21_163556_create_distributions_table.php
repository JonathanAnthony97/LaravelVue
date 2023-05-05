<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributions', function (Blueprint $table) {
            $table->increments('id_dist');
            $table->string('benef');
            $table->bigInteger('eff_benef');
            $table->integer('unite_dist');
            $table->bigInteger('qte_dist'); 
            $table->date('date_dist');

            //cle article
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
        Schema::dropIfExists('distributions');
    }
}
