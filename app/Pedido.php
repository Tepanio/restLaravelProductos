<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = "pedidos";
    protected $fillable = ['id'];
    protected $hidden = ['usuario_id'];
    
    public function productos(){
        return $this->belongsToMany(Producto::class);
    }
}
