<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categoria extends Model
{
    protected $table="categorias";
    protected $primarykey="id";
    protected $fillable=[
      'nombre',  'prefijo',
    ];
}
