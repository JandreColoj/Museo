@extends('templates.home')

@section('content')
<style type="text/css">
.bgimg {
    background-image: url('{{URL::asset("Images/libro2.png")}}');
    background-repeat: no-repeat;
    background-size: 100% 100%;
}
</style>
<div class="container">
  <div class="row">
    <div class="left">
      <h5 class="light">Libros de {{$categoria->nombre}} </h5>
    </div>
    <div class="right"><br>
      <a href="{{route('Libro.create')}}" class="modal-trigger btn-floating tooltipped btn-large waves-effect waves-light  light-blue darken-4" data-position="bottom" data-delay="50" data-tooltip="Agregar"><i class="material-icons">add</i></a>
    </div>
  </div>

  @if(($libros)==('[]'))
    <h5 class=" center">No se han agregado libros a la base de datos</h5>
  @endif

  <div id="libros" class="row section scrollspy">
    <div class="row">
    @foreach ($libros as $libro)

    <div class="col s6 m6 l3">
      <div class="card bgimg z-depth-5">
        <div class="card-content white-text">
          <p class="card-title center">{{$libro->nombre}}</p>
          <p class="medium center"><a href="{{route('Autor.show',$libro->idaut)}}">{{$libro->aut}}</a></p>
          <div class="divider"></div>
          <p class="light left">Edición: </p><p class="medium"> {{$libro->edicion}} </p>
          <p class="light left">Año: </p><p class="medium"> {{$libro->anio}} </p>
          <p class="light left">Páginas:</p><p class="medium "> {{$libro->paginas}} </p>
          <span class="light">Editorial: </span> <a href="{{route('Editorial.show',$libro->idedit)}}">{{$libro->edit}}</a><br>
          <span class="light">Categoría: </span> <a href="{{route('Categoria.show',$libro->idcat)}}">{{$libro->cat}}</a>
        </div>
      </div>
    </div>

    @endforeach
    </div>
  </div>
</div>
@endsection
@section('section')
<blockquote>
      Es una lista de los libros disponibles en la biblioteca.
</blockquote>
@endsection
