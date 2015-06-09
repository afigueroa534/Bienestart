<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Libro extends Model //implements AuthenticatableContract, CanResetPasswordContract{

   // use Authenticatable, CanResetPassword;
{
	//prueba
    protected $table = 'libros';


    public function getFullNameAttribute(){

        return $this->nombre.' '.$this->autor;
    }

    protected $fillable = ['nombre', 'autor', 'editorial'];
}