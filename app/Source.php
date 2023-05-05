<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $table = "sources";
    protected $primaryKey = 'id_s';
    public $timestamps = false;

    protected $guarded = [];
}
