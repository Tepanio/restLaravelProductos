<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable implements JWTSubject
{
    use Notifiable;
    public $timestamps = false;
    public $increment = false;
    protected $keyType = 'string';
    public $primaryKey  = 'username';

    protected $fillable = ['username','password','nombre','apellido','direccion','telefono','admin', 'email'];

    public function pedidos(){
        return $this->hasMany(Pedido::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
