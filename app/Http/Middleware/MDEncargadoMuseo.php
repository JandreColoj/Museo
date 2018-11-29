<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Contracts\Auth\Guard;
use App\permiso;
class MDEncargadoMuseo
{

    public function handle($request, Closure $next)
    {

      $useractual=Auth::User()->id;
      $permisos =permiso::join('users', 'permisos.iduser', '=', 'users.id')
          ->join('roles', 'permisos.idrol', '=', 'roles.id')
          ->select(
                  'roles.nombre as name'
                  )
          ->where('iduser', '=', $useractual)
          ->get();


      foreach ($permisos as $role)
       {
        if ($role->name=='Encargado Museo')
         {
          return $next($request);
        }
      }
      return new Response(view('mensajeerror.Error403')->with('msj','No tiene privilegios como encargado de administrar el museo'));

    }

}
