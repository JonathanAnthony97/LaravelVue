<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = "stocks";
    protected $primaryKey = 'id_st';
    public $timestamps = false;

    protected $guarded = [];

}
