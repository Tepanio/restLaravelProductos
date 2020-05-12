<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class producto extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $table = "productos";
    protected $fillable = ['nombre','precio','descripcion'];
    protected $hidden = ['pivot'];
}
