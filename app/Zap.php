<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zap extends Model
{
    protected $table = "zaps";
    protected $primaryKey = 'id_zap';
    public $timestamps = false;

    protected $guarded = [];
}
