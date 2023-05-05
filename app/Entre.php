<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entre extends Model
{
    protected $table = "entres";
    protected $primaryKey = 'id_e';
    public $timestamps = false;

    protected $guarded = [];
}
