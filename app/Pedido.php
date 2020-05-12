<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public $timestamps = false;
    protected $table = "pedidos";
    protected $fillable = ['id','estado'];
    
    public function productos(){
        return $this->belongsToMany(Producto::class)->withTrashed()->withPivot('cantidad');
    }
    
    public function factura()
    {
        return $this->hasOne(Factura::class);
    }
}
