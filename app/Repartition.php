<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repartition extends Model
{
    protected $table = "repartirs";
    protected $primaryKey = 'id_rep';
    public $timestamps = false;

    protected $guarded = [];
}
