@extends('dashboard.master')
@section('content')  
<div class="col-6 mb-3">
  <form action="{{route('post-comment.post',1)}}" id="filterForm">
    <div class="form-row">
      <div class="col-10">
        <select  id="filterPost" class="form-control">
        @foreach ($posts as $p)
          <option value="{{ $p->id}}" {{$post->id == $p->id ? 'selected' : ''}} >{{Str::limit($p->title,50)}}</option>
        @endforeach
        </select>
      </div>
      <div class="col-2">
        <button class="btn btn-success" type="submit">Enviar</button>
      </div>
    </div>
  </form>
</div>

@if (count($postComments)>0)
<table class="table">
    <thead>
        <tr>
            <td>Id</td>
            <td>Titulo</td>
            <td>Usuario</td>
            <td>Aprobado</td>
            <td>Mensaje</td>
            <td>Creación</td>
            <td>Actualizacion</td>
            <td>Acciones</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($postComments as $postComment)
        <tr>
            <td>{{$postComment->id}}</td>
            <td>{{$postComment->title}}</td>
            {{-- {{ dd($postComment->user)}} --}}
            <td>{{$postComment->user->name}}</td>
            <td>{{$postComment->approved}}</td>
            <td>{{$postComment->message}}</td>
            <td>{{$postComment->created_at->format('d-m-Y')}}</td>
            <td>{{$postComment->updated_at->format('d-M-Y')}}</td>
            <td>
                {{-- <a href="{{ route('post-comment.show',$postComment->id) }}" class="btn btn-primary">Ver</a> --}} 
                <button class="btn btn-primary" data-toggle="modal" data-target="#showModal" data-id="{{ $postComment->id }}">Ver</button>
                <button class="approved btn btn-{{ $postComment->approved ? "success" : "warning"}}" data-id="{{ $postComment->id }}">{{ $postComment->approved ? "Aprobado" : "Rechazado"}}</button>
                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $postComment->id }}">Eliminar</button>
            </td>
        </tr>            
        @endforeach
    </tbody>
</table>
{{ $postComments->links()}}


{{-- modal para borrado --}}
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
      <form id="formDelete" method="POST" action="{{ route('post-comment.destroy',0) }}" data-action="{{ route('post-comment.destroy',0) }}">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-danger" >Borrar</button>
      </form>        
      </div>
    </div>
  </div>
</div>

{{-- modal para ver el detalle --}}
<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Comentario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="message"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>    
      </div>
    </div>
  </div>
</div>

@else
   <h1>No hay comentarios para este post</h1> 
@endif
<script>
  document.querySelectorAll(".approved").forEach(button => button.addEventListener("click", function(){

    var id = button.getAttribute('data-id') //guardamos el id del atributo data-id del boton

    var formData =new FormData();
    formData.append("_token", '{{csrf_token()}}');

    fetch("{{URL::to('/')}}/dashboard/post-comment/process/"+id, {
      method:'POST',
      body: formData
    })
      .then(response => response.json())
      .then(approved => {
        if(approved == 1){
          button.classList.remove('btn-warning');
          button.classList.add('btn-success');
          button.innerHTML='Aprobado'
        } else {
          button.classList.add('btn-warning');
          button.classList.remove('btn-success');
          button.innerHTML='Rechazado'
        }
      });
    
  }));


  window.onload = function (){
    $('#showModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') //guardamos el id del atributo data-id del boton
        var modal = $(this);
        
        fetch("{{URL::to('/')}}/dashboard/post-comment/j-show/"+id)
          .then(response => response.json())
          .then(comment => {
            modal.find('.modal-title').text(comment.title);
            modal.find('.message').text(comment.message);
          });
/*         $.ajax({
          method: "GET",
          url: "{{URL::to('/')}}/dashboard/post-comment/j-show/"+id
        })
        .done(function( comment ){
          modal.find('.modal-title').text(comment.title);
          modal.find('.message').text(comment.message);
        }) */
    })

    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') //guardamos el id del atributo data-id del boton
        var action = $('#formDelete').attr('data-action').slice(0,-1); //guardamos la ruta del postComment pero le quitamos el ultimo caracter, que es 0 porque así lo hemos puesto en el data-action del form
        action += id; // y le añadimos el id
        $('#formDelete').attr('action',action); // una vez conseguida la url la pegamos al action del formulario
        var modal = $(this)
        modal.find('.modal-title').text('Vas a borrar el postComment: ' + id)
    })
    // cuando haya un cambio en el select de post tenemos que cambiar el action de nuestro form
    $("#filterForm").submit(function () {
  
      var action = $(this).attr('action');
      action = action.replace(/[0-9]/g, $("#filterPost").val());
      $(this).attr('action', action);

  });
  }
</script>
@endsection