<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\libro;
use App\autore;
use App\categoria;
use App\editoriale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibroController extends Controller
{

    public function index()
    {
        $libros=libro::join('autores', 'libros.idautor', '=', 'autores.id')
            ->join('editoriales', 'libros.ideditorial', '=', 'editoriales.id')
            ->join('categorias', 'libros.idcategoria', '=', 'categorias.id')
            ->select('libros.*', 'autores.nombre as aut','autores.id as idaut',
                    'editoriales.id as idedit','editoriales.nombre as edit',
                    'categorias.id as idcat','categorias.nombre as cat')
            ->get();
        $categorias=categoria::all();
        $editoriales=editoriale::all();
        $autores=autore::all();
        return view('libro.index',compact('libros','categorias','editoriales','autores'));
    }

    public function create()
    {
        $editoriales=editoriale::all();
        $autores=autore::all();
        $categorias=categoria::all();
        return view('libro.nuevolibro', compact('editoriales','autores','categorias'));
    }

    public function store(Request $request)
    {
      $user = Auth::user();
      $empleado=$user->empleado;
      $libro = new libro;
      $libro->nombre = $request->nombrelibro;
      $libro->idautor = $request->autor;
      $libro->edicion = $request->edicion;
      $libro->anio = $request->anio;
      $libro->paginas = $request->paginas;
      $libro->ideditorial = $request->editorial;
      $libro->idcategoria = $request->categoria;
      $libro->idempleado = $empleado;
      $libro->save();
      $categoria = categoria::findOrFail($libro->idcategoria);
      $cont = DB::table('libros')->where('idcategoria',$categoria->id)->count();
      if ($cont<10) {
        $libro->codigo = $categoria->prefijo .'00'. $cont;
      }
      elseif ($cont<100) {
        $libro->codigo = $categoria->prefijo .'0'. $cont;
      }
      else {
        $libro->codigo = $categoria->prefijo . $cont;
      }

      $libro->save();
      alert()-> success('Se ingeso correctamente el libro','Libro');
      return back();
    }

    public function show($id)
    {
        $libros=libro::join('autores', 'libros.idautor', '=', 'autores.id')
          ->join('editoriales', 'libros.ideditorial', '=', 'editoriales.id')
          ->join('categorias', 'libros.idcategoria', '=', 'categorias.id')
          ->select('libros.*', 'autores.nombre as aut','editoriales.nombre as edit','categorias.nombre as cat')
          ->get();
        return view ('libro.list',compact('libros'));
    }

    public function edit($id)
    {
        $libros=libro::join('autores', 'libros.idautor', '=', 'autores.id')
          ->join('editoriales', 'libros.ideditorial', '=', 'editoriales.id')
          ->join('categorias', 'libros.idcategoria', '=', 'categorias.id')
          ->select('libros.*', 'autores.nombre as aut','autores.id as idaut',
                  'editoriales.id as idedit','editoriales.nombre as edit',
                  'categorias.id as idcat','categorias.nombre as cat')
          ->where('libros.id', '=', $id)
          ->get();

          $editoriales=editoriale::all();
          $autores=autore::all();
          $categorias=categoria::all();
        return view ('libro.edit',compact('libros','editoriales','autores','categorias'));
    }

    public function update(Request $request,$id)
    {

      $libro = libro::find($id);
      $libro->nombre = $request->nombrelibro;
      $libro->idautor = $request->autor;
      $libro->edicion = $request->edicion;
      $libro->anio = $request->anio;
      $libro->paginas = $request->paginas;
      $libro->ideditorial = $request->editorial;
      $libro->idcategoria = $request->categoria;
      $libro->save();
      alert()-> success('Se actualizaron los campos correctamente','Libro');
      return redirect('Libro/0');
    }

    public function destroy($id)
    {
        $libro = libro::find($id);
        $libro->delete();
        alert()-> success('Eliminado correctamente','Libro');
        return back();
    }

    public function search(Request $request)
    {
      if ($request->ajax())
      {
     $output="";
      $donantes=libro::join('autores', 'libros.idautor', '=', 'autores.id')
          ->join('editoriales', 'libros.ideditorial', '=', 'editoriales.id')
          ->join('categorias', 'libros.idcategoria', '=', 'categorias.id')
          ->select('libros.*', 'autores.nombre as aut','autores.id as idaut',
                  'editoriales.id as idedit','editoriales.nombre as edit',
                  'categorias.id as idcat','categorias.nombre as cat','libros.codigo as cod')
                  ->where('libros.nombre','LIKE','%'.$request->search.'%')
                  ->orWhere('libros.codigo','LIKE','%'.$request->search.'%')
                  ->orWhere('categorias.nombre','LIKE','%'.$request->search.'%')
                  ->orWhere('autores.nombre','LIKE','%'.$request->search.'%')
                   ->get();
     $cont=1;
      if ($donantes)
       {
         $cont_libros = 0;
         foreach ($donantes as $key => $donantes)
          {

            $output.='
            <div class="col s6 m4 l3" style="margin: 5px; padding:1px;">
              <div class="card bgimg z-depth-5">
                <div class="card-content white-text">
                  <div class="" style="height:125px;">
                  <p class="card-title center " style="max-height: 5em; overflow:auto; font-size: 17px; ">'.$libros->nombre.'</p>
                  <p class="medium center">'.$libros->aut.'</p>
                  </div>
                  <div class="divider"></div>
                  <div class="" style="height:220px;">
                  <p class="light left">Edicion: </p><p class="medium"> '.$libros->edicion.'</p>
                  <p class="light left">Año: </p><p class="medium"> '.$libros->anio.'</p>
                  <p class="light left">Páginas: </p><p class="medium"> '.$libros->paginas.'</p>
                  <p class="light left">Editorial: </p> <p class="medium"> '.$libros->edit.'</p>
                  <p class="light left ">Categoria: </p> <p class="medium"> '.$libros->cat.'</p>
                  <p class="light left ">Código: </p> <p class="medium"> '.$libros->cod.'</p>
                  </div>
                </div>
              </div>
           </div>';
                     $cont++;
         }
         return Response($output);

       }
      }
    }
    public function searchCategoria(Request $request)
    {
      if ($request->ajax())
      {
       $output="";
       $cont = DB::table('libros')->where('idcategoria',$request->search)->count();
       $cont = $cont+1;
       $sql = DB::table('categorias')->where('id',$request->search)
                                         ->select('categorias.prefijo')
                                         ->get();
      $prefijo = 0;
      try{
        foreach ($sql as $tp)
        {$prefijo= $tp->prefijo;}
      }catch (\Exception $e)
      {$prefijo="ERROR";}
        if ($cont<10) {
          $output.='<h4>Código: '. $prefijo.'00'.$cont.'</h4>';
        }elseif($cont<100){
          $output.='<h4>Código: '. $prefijo.'0'.$cont.'</h4>';
        }else{
          $output.='<h4>Código: '. $prefijo .$cont.'</h4>';
        }
         return Response($output);
      }
    }

    public function searchsystem(Request $request)
    {
      if ($request->ajax())
      {
     $output="";
      $libros=libro::join('autores', 'libros.idautor', '=', 'autores.id')
          ->join('editoriales', 'libros.ideditorial', '=', 'editoriales.id')
          ->join('categorias', 'libros.idcategoria', '=', 'categorias.id')
          ->select('libros.*', 'autores.nombre as aut','autores.id as idaut',
                  'editoriales.id as idedit','editoriales.nombre as edit',
                  'categorias.id as idcat','categorias.nombre as cat',
                  'libros.codigo as cod')
                  ->where('libros.nombre','LIKE','%'.$request->search.'%')
                  ->orWhere('libros.codigo','LIKE','%'.$request->search.'%')
                  ->orWhere('categorias.nombre','LIKE','%'.$request->search.'%')
                  ->orWhere('autores.nombre','LIKE','%'.$request->search.'%')
                   ->get();
     $cont=1;
      if ($libros)
       {
         foreach ($libros as $key => $libros)
          {
            $output.='
            <div class="col s6 m4 l3" style="margin: 5px; padding:1px;">
              <div class="card bgimg z-depth-5">
                <div class="card-content white-text">
                  <div class="" style="height:125px;">
                  <p class="card-title center " style="max-height: 5em; overflow:auto; font-size: 17px; ">'.$libros->nombre.'</p>
                  <p class="medium center">'.$libros->aut.'</p>
                  </div>
                  <div class="divider"></div>
                  <div class="" style="height:220px;">
                  <p class="light left">Edicion: </p><p class="medium"> '.$libros->edicion.'</p>
                  <p class="light left">Año: </p><p class="medium"> '.$libros->anio.'</p>
                  <p class="light left">Páginas: </p><p class="medium"> '.$libros->paginas.'</p>
                  <p class="light left">Editorial: </p> <p class="medium"> '.$libros->edit.'</p>
                  <p class="light left ">Categoria: </p> <p class="medium"> '.$libros->cat.'</p>
                  <p class="light left ">Código: </p> <p class="medium"> '.$libros->cod.'</p>
                  </div>
                </div>
              </div>
           </div>';
                     $cont++;
         }
         return Response($output);

       }
      }
    }

    private function ActualizarCodigos()
    {
      $categorias = DB::table('categorias')->get();

      foreach ($categorias as $categoria) {
        $cont =0;
        $libros = DB::table('libros')->where('idcategoria',$categoria->id)->get();
        foreach ($libros as $libro) {
          $id = $libro->id;
          $cont++;
          if ($cont<10) {
            $libro = DB::table('libros')->where('id',$id)->update(['codigo' => $categoria->prefijo. '00' . $cont]);
          }
          elseif ($cont<100) {
            $libro = DB::table('libros')->where('id',$id)->update(['codigo' => $categoria->prefijo. '0' . $cont]);
          }
          else {
            $libro = DB::table('libros')->where('id',$id)->update(['codigo' => $categoria->prefijo. $cont]);
          }
        }
      }
    }
}
