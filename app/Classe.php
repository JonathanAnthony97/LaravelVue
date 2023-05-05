<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $table = "classes";
    protected $primaryKey = 'id_cls';
    public $timestamps = false;

    protected $guarded = [];
}
