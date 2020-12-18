@extends('dashboard.master')
@section('content')  
<a href="{{ route('category.create') }}" class="btn btn-primary btn-sm my-3">Crear categoría</a>
<table class="table">
    <thead>
        <tr>
            <td>Id</td>
            <td>Titulo</td>
            <td>URL</td>
            <td>Creación</td>
            <td>Actualizacion</td>
            <td>Acciones</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
        <tr>
            <td>{{$category->id}}</td>
            <td>{{$category->title}}</td>
            <td>{{$category->url_clean}}</td>
            <td>{{$category->created_at->format('d-m-Y')}}</td>
            <td>{{$category->updated_at->format('d-M-Y')}}</td>
            <td>
                <a href="{{ route('category.show',$category->id) }}" class="btn btn-primary">Ver</a> 
                <a href="{{ route('category.edit',$category->id) }}" class="btn btn-warning">Editar</a> 
                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $category->id }}">Eliminar</button> 
            </td>
        </tr>            
        @endforeach
    </tbody>
</table>
{{ $categories->links()}}



<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Borrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Seguro que quiere borrar el registro selecionado?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      <form id="formDelete" method="POST" action="{{ route('category.destroy',0) }}" data-action="{{ route('category.destroy',0) }}">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-danger" >Borrar</button>
      </form>        
      </div>
    </div>
  </div>
</div>
<script>
    window.onload = function (){
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') //guardamos el id del atributo data-id del boton
            var action = $('#formDelete').attr('data-action').slice(0,-1); //guardamos la ruta del post pero le quitamos el ultimo caracter, que es 0 porque así lo hemos puesto en el data-action del form
            action += id; // y le añadimos el id
            $('#formDelete').attr('action',action); // una vez conseguida la url la pegamos al action del formulario
            var modal = $(this)
            modal.find('.modal-title').text('Vas a borrar la categoría: ' + id)
        })
    }
</script>

@endsection