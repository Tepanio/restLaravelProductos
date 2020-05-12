<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    //
    public $timestamps = false;
    protected $table = "facturas";
    protected $fillable = ['total'];
    public function pedido(){
        $this->belongsTo(Pedido::class);
    }
}
