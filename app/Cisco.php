<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cisco extends Model
{
    protected $table = 'ciscos';
    protected $primaryKey = 'id_cisco';
    public $timestamps = false;

    protected $guarded = [];
}
