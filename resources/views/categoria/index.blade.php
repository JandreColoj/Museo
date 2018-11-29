@extends('templates.home')
@section('content')
<div class="container">
  <div class="row">
    <div class="left"><br>
      <h5 class="light text-light-blue text-darken-4">Categorías de libros</h5>
    </div>
    <div class="right"><br>
      <a href="#modalcreate" class="modal-trigger btn-floating tooltipped btn-large waves-effect waves-light  light-blue darken-4" data-position="bottom" data-delay="50" data-tooltip="Agregar"><i class="material-icons">add</i></a>
    </div>
  </div>
  @if(($result)==('[]'))
  <h5 class=" center">No se ha agregado ninguna categoría a la base de datos</h5>
  @else
  <div class="row">
    <div class="col s12">
      <div class="card">
        <table class="highlight bordered centered responsive-table">
          <thead class=" light-blue darken-4 white-text ">
            <tr>
              <th>Código</th>
              <th>Nombre categoría</th>
              <th>Prefijo</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            @foreach ($result as $r)
              <tr>
                <td>{{$r->id}}</td>
                <td>{{$r->nombre}}</td>
                <td>{{$r->prefijo}}</td>
                <td class="right">
                <a class="tooltipped  btn-floating btn-small waves-effect waves-light light-blue darken-1 modal-trigger" data-position="bottom" href="{{route('Categoria.edit',$r->id)}}" data-delay="50" data-tooltip="Editar categoria"><i class="material-icons">edit</i></a>

              </tr>

            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endif
    <form id="formValidate" action="{{route('Categoria.store')}}" method="POST">
      {{ csrf_field() }}
          <div id="modalcreate" class="modal">
            <div class="modal-content">
              <div class="row">
                <div class="center">
                  <h5 class="light">Nueva categoría de libros</h5>
                </div>
              </div>

              <div class="row"> <!-- INFORMACION GENERAL PIEZA -->
                <div class="input-field col l6 s12 center">
                  <i class="material-icons prefix">mode_edit</i>
                  <input id="" name="categoria" type="text" class="required">
                  <label for="uname">Nombre de categoría</label>
                </div>
                <div class="input-field l6 col s12 center">
                  <i class="material-icons prefix">sort_by_alpha</i>
                  <input id="" name="prefijo" type="text" class="required">
                  <label for="prefijo">Prefijo </label>
                </div>
                <div class="input-field col s12 center">
                  <button class="btn waves-effect waves-light  light-blue darken-4 center" type="submit" name="action">
                    Agregar
                  </button>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
            </div>
          </div>
    </form>

</div>


<script src="{{URL::asset('js/sweetalert.min.js')}}"></script>
@include('sweet::alert')
@endsection

@section('sections')
  <div class="center">
    <i class="medium material-icons">library_books</i>
    <p><strong>Categoria:</strong><br>
    División para poder distingir a que rama educativa pertenece el libro. Ej: <em>Matematica, Historia, Fisica</em></p>
  </div>
@endsection
