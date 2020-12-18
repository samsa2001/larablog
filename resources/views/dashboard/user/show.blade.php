@extends('dashboard.master')
@section('content')  

@include('dashboard.partials.validation-error')    
    <form action="{{ route("user.store")}}" method="POST">
    <?php // @csrf añade un token de seguridad para enviar el form, sin este token el formulario no funciona ?>
    @csrf  
    <div class="form-group">
        <label for="name">Nombre</label>
        <?php // old('campo') devuelve el contenido del input en caso de que no se procese el form por algún error ?>
        <input readonly type="text" name="name" class="form-control" id="name" value="{{ $user->name}}">
    </div>
    <div class="form-group">
        <label for="surname">Apellido</label>
        <input readonly type="text" name="surname" class="form-control" value="{{ $user->surname }}">
    </div>
    </form>
@endsection