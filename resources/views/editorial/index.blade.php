@extends('templates.home')
@section('content')
<div class="container">
  <div class="row">
    <div class="left"><br>
      <h5 class="light text-light-blue text-darken-4">Editoriales</h5>
    </div>
    <div class="right"><br>
      <a href="#modalcreate" class="modal-trigger btn-floating tooltipped btn-large waves-effect waves-light  light-blue darken-4" data-position="bottom" data-delay="50" data-tooltip="Agregar"><i class="material-icons">add</i></a>
    </div>
  </div>
  @if(($result)==('[]'))
  <h5 class=" center">No se ha agregado ninguna editorial a la base de datos</h5>
  @else
  <div class="row">
    <div class="col s12">
      <div class="card">
        <table class="highlight bordered centered responsive-table">
          <thead class="blue accent-3 white-text">
            <tr>
              <th>Codigo</th>
              <th>Editorial</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            @foreach ($result as $r)
              <tr>
                <td>{{$r->id}}</td>
                <td>{{$r->nombre}}</td>
                <td>
                <a class="tooltipped  btn-floating btn-small waves-effect waves-light light-blue darken-4 modal-trigger" data-position="bottom" href="{{route('Editorial.edit',$r->id)}}" data-delay="50" data-tooltip="Editar editorial"><i class="material-icons">edit</i></a>
                <a class="tooltipped  btn-floating btn-small waves-effect waves-light red modal-trigger" data-position="bottom" href="#modal{{$r->id}}" data-delay="50" data-tooltip="Eliminar editorial"><i class="material-icons">delete</i></a>
                </td>
              </tr>
              <form action="{{route('Editorial.destroy',$r->id)}}" method="POST">
                {{csrf_field()}}
                  <input type="hidden" name="_method" value="DELETE">
                    <div id="modal{{$r->id}}" class="modal">
                      <div class="modal-content">
                        <h4 class="center-align">Desea eliminar la editorial?</h4>
                        <center> <i class="center-align medium material-icons">error_outline</i></center>
                        <p class="center-align">Nota: los cambios no pueden deshacerse </p>
                      </div>
                      <div class="modal-footer">
                        <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
                        <button class="btn red" type="submit" name="action">Eliminar</button>
                      </div>
                    </div>
                </form>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endif
    <form action="{{route('Editorial.store')}}" method="POST"  id="formValidate">
      {{ csrf_field() }}
          <div id="modalcreate" class="modal">
            <div class="modal-content">
              <div class="row">
                <div class="center">
                  <h5 class="light">Nueva editorial</h5>
                </div>
              </div>
              <div class="row"> <!-- INFORMACION GENERAL PIEZA -->
                <div class="input-field col s12">
                  <i class="material-icons prefix">mode_edit</i>
                  <input id="" name="nombreeditorial" type="text" class="required">
                  <label for="uname">Nombre de la editorial</label>
                </div>
                <div class="input-field col s12 center">
                  <button class="btn wwaves-effect waves-light  light-blue darken-4 center" type="submit" name="action">
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
    <i class="medium material-icons">bookmark_border</i>
    <p><strong>Editorial:</strong><br>
     Empresa que se dedica a editar libros y otras publicaciones por medio de la imprenta u otros procedimientos de reproducción.</p>
  </div>
@endsection