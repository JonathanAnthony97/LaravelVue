<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    protected $table = "distributions";
    protected $primaryKey = 'id_dist';
    public $timestamps = false;

    protected $guarded = [];
}
