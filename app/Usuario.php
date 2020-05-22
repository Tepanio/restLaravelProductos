<?php

namespace App;

use App\Notifications\EmailVerificationNotification;
use App\Notifications\PasswordResetNotification;
use App\Notifications\PaymentReceivedNotification;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;

    //public $timestamps = false;
    public $increment = false;
    protected $keyType = 'string';
    protected $primaryKey  = 'username';

    protected $fillable = ['username','password','nombre','apellido','direccion','telefono','admin', 'email'];
    protected $hidden = [
        'password',
    ];
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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification());
    }

    public function sendPaymentReceivedNotification()
    {
        $this->notify(new PaymentReceivedNotification());
    }
}
