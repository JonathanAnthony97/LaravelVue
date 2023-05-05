<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    protected $table = "etablissements";
    protected $primaryKey = 'id_etab';
    public $timestamps = false;

    protected $guarded = [];
}
