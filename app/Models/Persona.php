<?php namespace ConsultaMedica\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Persona  extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;


    protected $table = 'persona';

    public function scopeLogin($query, $login){
        return $query->where('login', $login)->get();
    }

    public function scopeClave(){
        return $this->clave;
    }


    public function getFullNameAttribute(){

        return $this->nombre.' '.$this->autor;
    }

    protected $fillable = ['cedula','login','nombre','apellido','direccion','email','clave','fecha_nac','telefono','tipo_per','sexo','remember_token'];

   // protected $hidden = ['password', 'remember_token'];
}