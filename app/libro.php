<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class libro extends Model
{
    protected $table="libros";
    protected $primarykey="id";
    protected $fillable=[
      'codigo','nombre','anio','edicion','paginas','idautor','ideditorial','idcategoria','idempleado',
    ];
}
