<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public $timestamps = false;
    public $increment = false;
    protected $keyType = 'string';
    protected $table = "usuarios";
    protected $fillable = ['id','nombre','apellido','direccion','telefono','super'];
    
    public function pedidos(){
        return $this->hasMany(Pedido::class);
    }
}
