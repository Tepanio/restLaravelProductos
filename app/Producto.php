<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    protected $table = "productos";
    protected $fillable = ['nombre','precio'];
    protected $hidden = ['pivot'];
}
