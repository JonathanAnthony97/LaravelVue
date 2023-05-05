<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = "articles";
    protected $primaryKey = 'id_a';
    public $timestamps = false;

    protected $guarded = [];
    
}
